# Website Profil MA Mabadi'ul Ihsan (MAMIHA)

Repositori ini berisi source code untuk **Website Profil Madrasah Aliyah (MA) Mabadi'ul Ihsan** – platform informasi dinamis untuk berita, prestasi, profil, galeri foto & video, PPDB, dan manajemen konten berbasis **CodeIgniter 4 + Tailwind CSS 4 + Vite 7**.

## Live Preview
Preview Website: https://mamabadiulihsan.sch.id

## Tech Stack Terkini (2026-08)

**Backend:**
- Framework: CodeIgniter 4.7.4 (PHP ^8.2, tested PHP 8.5.4)
- Database: MariaDB 11.8 / MySQL 8.0 (MySQLi, utf8mb4)
- Security: HTMLPurifier 4.19, CSRF session + tokenRandomize, SecureHeaders, Honeypot
- PHP Extensions: `intl, mbstring, curl, gd, mysqlnd, pdo_mysql, mysqli, zip, xml, openssl` (wajib `gd` untuk WebP, `mysqli` untuk CI4)

**Frontend:**
- Styling: Tailwind CSS 4.2.1 (`@tailwindcss/vite`)
- Build: Vite 7.3.1 (`manifest:true` + hash `css/app-[hash].css` untuk cache-busting, output `public/.vite/manifest.json`)
- Interaktivitas: Alpine.js 3 (collapse, dropdown Galeri/Berita/Profil, mobile menu)
- UI: Swiper.js 11 (Hero Slider), FontAwesome 6, Fancybox 5 (Galeri Video)

## Fitur Utama

- **Halaman Publik Dinamis:** Hero Slider (3 slide desktop+mobile), Berita (9 dummy, filter kategori/tahun/urutan + paginate 9), Prestasi (6, filter cari/kategori/tahun + paginate 9), Pengumuman, Kalender Akademik (group bulan), Galeri Foto (3 album x8 foto, paginate 12) **+ Galeri Video (4 video: 3 landscape +1 portrait, tab Foto↔Video bidirectional)**, Fasilitas, Guru/Staff, Bakat Minat, Testimoni, Unduhan, Alumni, PPDB.
- **CMS Admin:** Dashboard + CRUD Berita/Kategori/Tags, Prestasi, Galeri Foto+Video (Dropzone uploadPhotos), Pengumuman, Kalender, Fasilitas, Guru, Bakat Minat, PPDB, Akses Cepat, Hero, Kegiatan, Testimoni, Profil. Semua delete/approve via `POST` + `csrf_field()` (anti CSRF GET).
- **Responsive & Modern UI:** Mobile-first Tailwind, `object-fit:cover`, `aspect-ratio`, `loading=lazy`, cache `Cache-Control 1 year` untuk css/webp.
- **Keamanan & Performa:** `session regenerate(true)` anti fixation, brute-force cache 15 menit, `X-Frame-Options/X-Content-Type-Options/Referrer-Policy`, `public/uploads/.htaccess` blokir `.php`, pagination anti OOM, `cache()->remember` untuk `pengaturan/akses_cepat/pendaftaran`, N+1 fix `whereIn` untuk galeri fasilitas.

## Persyaratan Sistem

- PHP 8.2+ (disarankan 8.5), `composer 2.x`, `Node.js 22` + `npm 9+`
- Ekstensi PHP: `intl, mbstring, curl, gd, mysqlnd, mysqli, pdo_mysql, zip, xml, openssl`
- Database: MariaDB 11.8 / MySQL 8.0 (create `mamiha_db` + user `mamiha_user`)
- OS: Ubuntu 26.04 LTS tested

## Panduan Instalasi (Lokal)

**1. Clone Repositori**
```bash
git clone https://github.com/ihsanfeelance21/mamiha.git
cd mamiha
```

**2. Instalasi Dependensi Backend & Frontend**
```bash
composer install
npm install
npm run build   # hasil: public/css/app-[hash].css + public/.vite/manifest.json
# atau dev: npm run dev / npm run watch
```

**3. Konfigurasi Environment**
```bash
cp env .env
```
Edit `.env`:
```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080'
app.forceGlobalSecureRequests = false  # true untuk production https
app.CSPEnabled = false

database.default.hostname = localhost
database.default.database = mamiha_db
database.default.username = mamiha_user
database.default.password = GrMMLo7JLW6x1tJ
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

encryption.key = hex2bin:YOUR_32BYTE_HEX
# production overrides lihat .env bagian bawah: cookie.secure, security.tokenRandomize, database.DBDebug=false
```

**4. Persiapan Database (MariaDB keep sudo mysql)**
```bash
# root pakai unix_socket (sudo)
pkexec mysql -u root -e "CREATE DATABASE mamiha_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; CREATE USER 'mamiha_user'@'localhost' IDENTIFIED BY 'GrMMLo7JLW6x1tJ'; GRANT ALL ON mamiha_db.* TO 'mamiha_user'@'localhost'; FLUSH PRIVILEGES;"
# atau sudo mysql

php spark migrate
php spark db:seed DummySeeder   # overwrite truncate + generate 9 berita, 6 prestasi, 3 album (24 foto), 4 video, 10 kalender, dll
# alternatif: php spark db:seed DatabaseSeeder  # + admin user (admin/admin123)

# verifikasi
mysql -u mamiha_user -p mamiha_db -e "SELECT COUNT(*) FROM berita; SELECT COUNT(*) FROM galeri_video;"
```

**5. Jalankan Server**
```bash
php spark serve --port 8080
# buka http://localhost:8080 , http://localhost:8080/galeri , http://localhost:8080/galeri-video
# login admin: http://localhost:8080/login  (admin/admin123 jika pakai DatabaseSeeder)
```

**6. Pengembangan Tailwind**
```bash
npm run watch   # rebuild css saat edit src/css/app.css
npm run build   # production build dengan hash
```

## Struktur Penting

```
app/Controllers/  -> Home, Berita, PrestasiController, GaleriController (foto+video), Profil, etc.
app/Views/layouts/main.php -> navbar dropdown Galeri (Foto/Video), Berita (Berita/Prestasi/Pengumuman), Profil; cache pengaturan
public/.vite/manifest.json -> mapping css hash
public/uploads/ -> .htaccess blokir php (mod_php, SetHandler, Nginx deny)
app/Database/Seeds/DummySeeder.php -> seeder lengkap (hapus truncate, buatGambar gradasi hijau, buatPdf)
```

## Keamanan Production Checklist

- `.env` jangan commit, `CI_ENVIRONMENT=production`, `app.baseURL=https://domain`, `app.forceGlobalSecureRequests=true`, `cookie.secure=true`, `database.DBDebug=false`, `security.regenerate=true`, `logger.threshold=4`
- `public/.htaccess` uncomment `Force HTTPS` + `Header Strict-Transport-Security`
- `vite` hash sudah aktif, `Cache-Control immutable` 1 tahun
- `php spark optimize` + `opcache.preload` (preload.php) untuk performa

## Referensi
- CI4 User Guide: https://codeigniter4.github.io/userguide/
- Dummy data: semua konten terisi via `DummySeeder` (overwrite truncate, setiap konten ada)
