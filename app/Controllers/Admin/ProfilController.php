<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfilWebsiteModel;
use App\Models\FasilitasModel;
use App\Models\FasilitasGaleriModel;

class ProfilController extends BaseController
{
    protected $profilModel;
    protected $fasilitasModel;
    protected $galeriModel;

    public function __construct()
    {
        $this->profilModel    = new ProfilWebsiteModel();
        $this->fasilitasModel = new FasilitasModel();
        $this->galeriModel    = new FasilitasGaleriModel();
    }

    public function index()
    {
        // Ambil data profil baris pertama (karena kita cuma pakai 1 baris)
        $data['profil'] = $this->profilModel->first();

        // Ambil data fasilitas untuk nanti
        $data['fasilitas'] = $this->fasilitasModel->findAll();

        return view('admin/profil/index', $data);
    }

    // Fungsi untuk menyimpan perubahan Kilas Balik, Visi Misi, Tentang Kami
    public function updateUmum()
    {
        $profilLama = $this->profilModel->first();

        // Atur data yang akan diupdate
        $dataUpdate = [
            'kilas_balik_deskripsi'  => $this->request->getPost('kilas_balik_deskripsi'),
            'visi'                   => $this->request->getPost('visi'),
            'misi'                   => $this->request->getPost('misi'),
            'tentang_kami_judul'     => $this->request->getPost('tentang_kami_judul'),
            'tentang_kami_deskripsi' => $this->request->getPost('tentang_kami_deskripsi'),
            'tentang_kami_video_tipe' => $this->request->getPost('tentang_kami_video_tipe'),
            'tentang_kami_video'     => $this->request->getPost('tentang_kami_video'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ];

        // Cek apakah ada upload foto kilas balik baru
        $fotoKilasBalik = $this->request->getFile('kilas_balik_foto');
        if ($fotoKilasBalik && $fotoKilasBalik->isValid() && ! $fotoKilasBalik->hasMoved()) {
            $namaFotoBaru = $fotoKilasBalik->getRandomName();
            $fotoKilasBalik->move('uploads/profil', $namaFotoBaru);

            // Hapus foto lama jika ada
            if ($profilLama['kilas_balik_foto'] && file_exists('uploads/profil/' . $profilLama['kilas_balik_foto'])) {
                unlink('uploads/profil/' . $profilLama['kilas_balik_foto']);
            }

            $dataUpdate['kilas_balik_foto'] = $namaFotoBaru;
        }

        // Simpan ke database (Update baris ID 1)
        $this->profilModel->update($profilLama['id'], $dataUpdate);

        return redirect()->to('admin/profil')->with('pesan', 'Data Profil Website berhasil diperbarui!');
    }
    // ==========================================
    // FUNGSI CRUD FASILITAS
    // ==========================================

    public function simpanFasilitas()
    {
        $fotoCover = $this->request->getFile('foto_cover');
        $namaFoto = null;

        if ($fotoCover && $fotoCover->isValid() && ! $fotoCover->hasMoved()) {
            $namaFoto = $fotoCover->getRandomName();
            $fotoCover->move('uploads/fasilitas', $namaFoto); // Pastikan folder public/uploads/fasilitas ada
        }

        $this->fasilitasModel->save([
            'judul'      => $this->request->getPost('judul'),
            'icon'       => $this->request->getPost('icon'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'foto_cover' => $namaFoto
        ]);

        return redirect()->to('admin/profil')->with('pesan', 'Fasilitas baru berhasil ditambahkan!');
    }

    public function updateFasilitas($id)
    {
        $fasilitasLama = $this->fasilitasModel->find($id);
        $fotoCover = $this->request->getFile('foto_cover');
        $namaFoto = $fasilitasLama['foto_cover'];

        // Jika admin upload foto cover baru
        if ($fotoCover && $fotoCover->isValid() && ! $fotoCover->hasMoved()) {
            $namaFoto = $fotoCover->getRandomName();
            $fotoCover->move('uploads/fasilitas', $namaFoto);

            // Hapus foto lama
            if ($fasilitasLama['foto_cover'] && file_exists('uploads/fasilitas/' . $fasilitasLama['foto_cover'])) {
                unlink('uploads/fasilitas/' . $fasilitasLama['foto_cover']);
            }
        }

        $this->fasilitasModel->update($id, [
            'judul'      => $this->request->getPost('judul'),
            'icon'       => $this->request->getPost('icon'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'foto_cover' => $namaFoto
        ]);

        return redirect()->to('admin/profil')->with('pesan', 'Data Fasilitas berhasil diperbarui!');
    }

    public function hapusFasilitas($id)
    {
        $fasilitas = $this->fasilitasModel->find($id);

        // Hapus file fisik foto cover
        if ($fasilitas['foto_cover'] && file_exists('uploads/fasilitas/' . $fasilitas['foto_cover'])) {
            unlink('uploads/fasilitas/' . $fasilitas['foto_cover']);
        }

        // Hapus dari database (Data Galeri akan otomatis terhapus karena CASCADE di database)
        $this->fasilitasModel->delete($id);

        return redirect()->to('admin/profil')->with('pesan', 'Fasilitas berhasil dihapus!');
    }
    // ==========================================
    // FUNGSI CRUD GALERI FASILITAS
    // ==========================================

    public function galeriFasilitas($id)
    {
        $data['fasilitas'] = $this->fasilitasModel->find($id);

        // Jika fasilitas tidak ditemukan, kembalikan ke halaman profil
        if (!$data['fasilitas']) {
            return redirect()->to('admin/profil')->with('pesan', 'Fasilitas tidak ditemukan.');
        }

        $data['galeri'] = $this->galeriModel->where('fasilitas_id', $id)->findAll();

        return view('admin/profil/galeri', $data);
    }

    public function simpanGaleri()
    {
        $fasilitas_id = $this->request->getPost('fasilitas_id');
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            // Kita simpan di subfolder khusus galeri
            $foto->move('uploads/fasilitas/galeri', $namaFoto);

            $this->galeriModel->save([
                'fasilitas_id' => $fasilitas_id,
                'foto'         => $namaFoto,
                'created_at'   => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('admin/profil/fasilitas/galeri/' . $fasilitas_id)->with('pesan', 'Foto berhasil ditambahkan ke Galeri!');
        }

        return redirect()->back()->with('pesan', 'Gagal mengupload foto. Pastikan format file benar.');
    }

    public function hapusGaleri($id)
    {
        $galeri = $this->galeriModel->find($id);

        if ($galeri) {
            // Hapus file fisik
            if ($galeri['foto'] && file_exists('uploads/fasilitas/galeri/' . $galeri['foto'])) {
                unlink('uploads/fasilitas/galeri/' . $galeri['foto']);
            }
            // Hapus data di database
            $this->galeriModel->delete($id);
            return redirect()->back()->with('pesan', 'Foto galeri berhasil dihapus!');
        }

        return redirect()->back()->with('pesan', 'Foto tidak ditemukan.');
    }
}
