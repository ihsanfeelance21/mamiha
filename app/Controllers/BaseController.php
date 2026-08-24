<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    /**
     * Fungsi untuk mengecek hak akses user secara internal di Controller.
     * Melempar RedirectException agar eksekusi langsung berhenti & diarahkan
     * ke dashboard jika user tidak punya izin.
     */
    protected function cekIzin($slug)
    {
        if (session()->get('role') === 'superadmin') {
            return true;
        }

        // Cek dari session cache dulu (diisi saat login via Auth.php)
        $perms = session()->get('permissions');
        if (is_array($perms)) {
            if (in_array($slug, $perms, true)) return true;
            // fallback ke DB jika session kosong tapi masih login (misal session lama)
        }

        $db = \Config\Database::connect();
        $hasAccess = $db->table('user_permissions')
            ->where('id_user', session()->get('id_user'))
            ->where('menu_slug', $slug)
            ->countAllResults() > 0;

        if (! $hasAccess) {
            $redirect = redirect()->to('admin/dashboard')
                ->with('error', 'Anda tidak memiliki akses ke menu tersebut.')
                ->withInput();

            throw new \CodeIgniter\HTTP\Exceptions\RedirectException($redirect);
        }

        return true;
    }

    /**
     * Helper aman untuk upload file gambar/PDF.
     * Memvalidasi MIME & ekstensi untuk mencegah shell upload.
     *
     * @return string|null Nama file jika sukses, null jika gagal
     */
    protected function prosesUpload($file, string $folder, array $allowedMime = [], array $allowedExt = [], int $maxMb = 5)
    {
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        // Batasi ukuran file
        if ($file->getSize() > $maxMb * 1024 * 1024) {
            return null;
        }

        // Deteksi MIME sesungguhnya dari file (bukan dari header klien)
        $mime = (string) $file->getMimeType();
        if ($allowedMime !== [] && ! in_array($mime, $allowedMime, true)) {
            return null;
        }

        // Whitelist ekstensi
        $ext = strtolower($file->getExtension());
        if ($allowedExt !== [] && ! in_array($ext, $allowedExt, true)) {
            return null;
        }

        // Nama acak + move aman
        $nama = $file->getRandomName();
        $tujuan = FCPATH . 'uploads/' . trim($folder, '/');
        if (! is_dir($tujuan)) {
            mkdir($tujuan, 0755, true);
        }

        $file->move($tujuan, $nama);

        return $nama;
    }

    /**
     * Konstanta MIME umum untuk gambar.
     */
    protected function mimeGambar(): array
    {
        return ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/avif'];
    }

    /**
     * Bersihkan HTML (konten berita/pengumuman) dari serangan XSS
     * menggunakan HTML Purifier.
     */
    protected function bersihkanHtml(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,b,strong,i,em,u,s,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6,br,hr,a[href|title|target],img[src|alt|title|width|height],span[style],div[style],pre,code,table,thead,tbody,tr,td,th');
        $config->set('Attr.AllowedFrameTargets', ['_blank', '_self', '_top']);
        $config->set('HTML.Nofollow', true);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);

        $purifier = new \HTMLPurifier($config);

        return $purifier->purify($html);
    }
}
