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
        $this->cekIzin('profil');
        // Ambil data profil baris pertama (karena kita cuma pakai 1 baris)
        $data['profil'] = $this->profilModel->first();

        // Ambil data fasilitas untuk nanti
        $data['fasilitas'] = $this->fasilitasModel->findAll();

        return view('admin/profil/index', $data);
    }

    // Fungsi untuk menyimpan perubahan Kilas Balik, Visi Misi, Tentang Kami
    public function updateUmum()
    {
        $this->cekIzin('profil');
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
        $namaFotoBaru = $this->prosesUpload($fotoKilasBalik, 'profil', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
        if ($namaFotoBaru) {
            // Hapus foto lama jika ada
            if ($profilLama['kilas_balik_foto'] && file_exists(FCPATH . 'uploads/profil/' . $profilLama['kilas_balik_foto'])) {
                unlink(FCPATH . 'uploads/profil/' . $profilLama['kilas_balik_foto']);
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
        $this->cekIzin('profil');
        $fotoCover = $this->request->getFile('foto_cover');
        $namaFoto = $this->prosesUpload($fotoCover, 'fasilitas', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);

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
        $this->cekIzin('profil');
        $fasilitasLama = $this->fasilitasModel->find($id);
        $fotoCover = $this->request->getFile('foto_cover');
        $namaFoto = $fasilitasLama['foto_cover'];

        // Jika admin upload foto cover baru
        $baru = $this->prosesUpload($fotoCover, 'fasilitas', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
        if ($baru) {
            $namaFoto = $baru;

            // Hapus foto lama
            if ($fasilitasLama['foto_cover'] && file_exists(FCPATH . 'uploads/fasilitas/' . $fasilitasLama['foto_cover'])) {
                unlink(FCPATH . 'uploads/fasilitas/' . $fasilitasLama['foto_cover']);
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
        $this->cekIzin('profil');
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
        $this->cekIzin('profil');
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
        $this->cekIzin('profil');
        $fasilitas_id = $this->request->getPost('fasilitas_id');
        $foto = $this->request->getFile('foto');

        $namaFoto = $this->prosesUpload($foto, 'fasilitas/galeri', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);

        if ($namaFoto) {
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
        $this->cekIzin('profil');
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
