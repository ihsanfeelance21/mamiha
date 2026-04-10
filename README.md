# Website Profil MA Mabadi'ul Ihsan

Repositori ini berisi *source code* untuk Website Profil Madrasah Aliyah (MA) Mabadi'ul Ihsan. Sistem ini dirancang untuk menjadi platform informasi sekolah yang dinamis, cepat, dan responsif, mengelola konten publik seperti berita terkini, data prestasi siswa, profil madrasah, hingga testimoni.

Proyek ini dibangun dari nol dan merupakan salah satu proyek utama dalam portofolio saya sebagai Junior Web Developer, mendemonstrasikan implementasi *framework* MVC di sisi *backend* dan *utility-first* CSS di sisi *frontend*.

## Tech Stack

Proyek ini dibangun menggunakan teknologi berikut:

- **Backend:** CodeIgniter 4 (PHP Framework)
- **Frontend:** HTML5, Tailwind CSS (Utility-first CSS framework)
- **JavaScript Libraries:** - Alpine.js (Untuk interaktivitas UI ringan seperti *dropdown* dan *mobile menu*)
                            - Swiper.js (Untuk fitur *slider* karosel yang responsif)
- **Database:** MySQL / MariaDB
- **Icons:** FontAwesome 6

## Fitur Utama

- **Halaman Publik Dinamis:** Menampilkan data secara *real-time* dari *database* (Hero Slider, Berita/Kabar Sekolah, Prestasi Siswa, Testimoni, dan Video Profil).
- **Manajemen Konten (CMS):** Sistem *backend* yang memungkinkan admin untuk menjadwalkan perilisan berita, menambah data prestasi, dan menyetujui testimoni.
- **Responsif & Modern UI:** Antarmuka yang dioptimalkan untuk perangkat seluler (*mobile-first*) dengan animasi halus dan tata letak yang rapi berkat Tailwind CSS.
- **Keamanan:** Implementasi filter rilis konten (hanya menampilkan status 'terbit' dan waktu rilis yang valid) serta proteksi *query builder* bawaan CodeIgniter 4.

## Server Requirements

Pastikan *environment* server atau lokal Anda memenuhi persyaratan minimum berikut sebelum menjalankan aplikasi:

- **PHP:** Versi 8.2 atau yang lebih baru.
- **Database:** MySQL (dengan ekstensi `mysqlnd` diaktifkan).
- **Ekstensi PHP yang Wajib Aktif:**
  - `intl`
  - `mbstring`
  - `json` (aktif secara bawaan)
  - `libcurl` (jika menggunakan fitur HTTP\CURLRequest)

## Installation and Local Setup

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di mesin lokal Anda (localhost):

**1. Clone Repositori**
Buka terminal dan jalankan perintah berikut untuk mengunduh *source code*:
```bash
git clone https://github.com/ihsanfeelance21/mamiha.git
cd mamiha
```

**2. Instalasi Dependensi Backend**
Pastikan Anda sudah menginstal [Composer](https://getcomposer.org/). Jalankan perintah berikut untuk menginstal dependensi CodeIgniter 4:
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

## Dokumentasi Framework

Informasi lebih lanjut mengenai tata cara penggunaan dan arsitektur CodeIgniter 4 dapat ditemukan di [User Guide Resmi CodeIgniter](https://codeigniter.com/user_guide/).
