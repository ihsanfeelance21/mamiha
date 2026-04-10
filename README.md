# Website Profil MA Mabadi'ul Ihsan

Repositori ini berisi source code untuk Website Profil Madrasah Aliyah (MA) Mabadi'ul Ihsan. Sistem ini dirancang untuk menjadi platform informasi sekolah yang dinamis, cepat, dan responsif guna mengelola konten publik seperti berita terkini, data prestasi siswa, profil madrasah, dan testimoni.

Proyek ini dibangun dari nol dan merupakan salah satu proyek utama dalam portofolio saya sebagai Web Developer, mendemonstrasikan implementasi pola arsitektur MVC di sisi backend dan utility-first CSS di sisi frontend.

## Live Preview

[Tautan ke Website Live] https://mamabadiulihsan.sch.id

## Tech Stack

Proyek ini dibangun menggunakan teknologi modern berikut:

**Backend:**
* Framework: CodeIgniter 4 (PHP)
* Database: MySQL / MariaDB

**Frontend:**
* Styling: Tailwind CSS
* Interaktivitas: Alpine.js (Dropdown, Mobile Menu)
* UI Components: Swiper.js (Responsive Carousel Slider)
* Assets: FontAwesome 6

## Fitur Utama

* **Halaman Publik Dinamis:** Menampilkan data secara real-time dari database, termasuk Hero Slider, Kabar Sekolah, Prestasi Siswa, Testimoni, dan Video Profil.
* **Content Management System (CMS):** Sistem backend khusus bagi admin untuk menjadwalkan perilisan berita, mengelola data prestasi, dan memoderasi testimoni.
* **Responsive & Modern UI:** Antarmuka yang dioptimalkan untuk berbagai ukuran layar (mobile-first approach) dengan transisi antarmuka yang presisi menggunakan Tailwind CSS.
* **Keamanan Terpusat:** Implementasi filter rilis konten (hanya menampilkan status 'terbit' dengan waktu rilis valid) dan proteksi terhadap SQL Injection melalui Query Builder bawaan CodeIgniter 4.

## Persyaratan Sistem

Pastikan environment server atau lokal Anda memenuhi persyaratan minimum berikut sebelum menjalankan aplikasi:

* PHP: Versi 8.2 atau lebih baru
* Database: MySQL (dengan ekstensi mysqlnd diaktifkan)
* Ekstensi PHP Wajib: intl, mbstring, json, libcurl

## Panduan Instalasi (Lokal)

Ikuti langkah-langkah di bawah ini untuk mengonfigurasi dan menjalankan proyek ini di environment localhost Anda.

**1. Clone Repositori**
```bash
git clone [https://github.com/ihsanfreelance21/mamiha.git](https://github.com/ihsanfreelance21/mamiha.git)
cd mamiha
```

**2. Instalasi Dependensi Backend**
Pastikan Composer sudah terinstal di sistem Anda, kemudian jalankan perintah berikut untuk mengunduh dependensi framework:
```bash
composer install
```

**3. Konfigurasi Environment**
Gandakan (copy) file `env` bawaan CI4 menjadi `.env` agar dapat dikonfigurasi:
```bash
cp env .env
```
Buka file `.env` menggunakan *code editor* Anda dan sesuaikan pengaturan berikut:
- Hilangkan tanda pagar (`#`) pada baris `CI_ENVIRONMENT` dan ubah menjadi `development` (untuk melihat pesan *error* secara detail saat proses *development*).
- Konfigurasi URL utama:
  `app.baseURL = 'http://localhost:8080/'`
- Konfigurasi *Database*:
  ```env
  database.default.hostname = localhost
  database.default.database = nama_database_anda
  database.default.username = root
  database.default.password = 
  database.default.DBDriver = MySQLi
  database.default.port     = 3306
  ```

**4. Persiapan Database**
- Buat *database* kosong di MySQL/phpMyAdmin Anda dengan nama sesuai konfigurasi `.env`.
- Lakukan *import* struktur tabel dan data sampel dari file SQL yang telah disediakan (jika ada, misalnya `database.sql`), atau jalankan migrasi database CodeIgniter jika Anda menggunakan fitur *Migrations*:
```bash
php spark migrate
```

**5. Tailwind CSS (Opsional / Development)**
Aplikasi ini sudah menyertakan file CSS yang telah dikompilasi di `public/css/app.css`. Namun, jika Anda ingin memodifikasi tampilan Tailwind, Anda perlu menginstal dependensi Node.js dan menjalankan *watcher*:
```bash
npm install
npm run watch
```

**6. Menjalankan Development Server**
Setelah semua konfigurasi selesai, jalankan server bawaan CodeIgniter 4:
```bash
php spark serve
```
Buka *browser* Anda dan akses `http://localhost:8080`.

## Kompilasi Asset Frontend (Opsional)
Aplikasi ini sudah menyertakan file CSS hasil kompilasi yang siap pakai di direktori public/css/app.css. Namun, jika Anda perlu memodifikasi atau menambahkan kelas Tailwind CSS baru, Anda wajib menginstal dependensi Node.js dan menjalankan script watcher:

```bash
npm install
npm run watch
```

## Referensi Tambahan
Dokumentasi teknis menyeluruh mengenai tata cara penggunaan framework dapat dilihat di CodeIgniter 4 Official User Guide.
