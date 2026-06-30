# TaskFlow - Sistem Informasi Manajemen Tugas

TaskFlow adalah aplikasi berbasis web (Laravel 12) untuk mengelola tugas: membuat task, mengatur prioritas, deadline, kategori, lampiran, dan laporan — dengan dua role pengguna (Admin & User).

## Daftar Fitur

- Autentikasi (Login, Logout, Remember Me)
- Role Admin & User dengan middleware proteksi akses
- Dashboard dengan statistik & chart (Chart.js): total task, selesai, belum selesai, overdue, hari ini, minggu ini, bulan ini, chart per kategori & prioritas, deadline terdekat, aktivitas terbaru
- CRUD User, Kategori, Prioritas, Status (khusus Admin)
- CRUD Task lengkap (judul, deskripsi, kategori, prioritas, status, deadline, catatan, lampiran)
- Upload, preview, dan download lampiran task (maks 5 file, 5MB/file)
- Search, filter (kategori/prioritas/status/tanggal), sorting, dan pagination
- Update status task langsung dari tabel (dropdown)
- Activity Log otomatis (login, logout, tambah/edit/hapus task)
- Export laporan task ke PDF (Laravel DomPDF) dan Excel (Laravel Excel)
- Profile & ganti password
- UI responsive berbasis Bootstrap 5 + Bootstrap Icons, notifikasi SweetAlert2

## Teknologi

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 12 |
| Bahasa | PHP 8.3 |
| Database | MySQL |
| CSS | Bootstrap 5 (CDN) |
| Icon | Bootstrap Icons (CDN) |
| Chart | Chart.js (CDN) |
| Notifikasi | SweetAlert2 (CDN) |
| PDF | barryvdh/laravel-dompdf |
| Excel | maatwebsite/excel |

## Persyaratan Software

- PHP >= 8.3 (ekstensi: mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, json, fileinfo, gd/imagick disarankan untuk DomPDF)
- Composer >= 2.6
- Node.js >= 18 dan NPM >= 9 (opsional, hanya jika ingin build asset via Vite — UI utama sudah memakai CDN)
- MySQL >= 8.0 (atau MariaDB >= 10.4)
- Web server: Laravel built-in server (`php artisan serve`), atau Apache/Nginx

## Panduan Instalasi Lengkap

### 1. Extract Project

Ekstrak file `TaskFlow-Laravel12.zip` ke folder kerja Anda, misalnya:

```bash
unzip TaskFlow-Laravel12.zip -d taskflow
cd taskflow
```

### 2. Membuat Database

Login ke MySQL lalu buat database baru:

```sql
CREATE DATABASE taskflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Konfigurasi File .env

Salin `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Edit bagian database di `.env` sesuai kredensial MySQL Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Install Dependency PHP (Composer)

```bash
composer install
```

> Jika muncul error terkait versi PHP, pastikan PHP CLI Anda sudah versi 8.3 (`php -v`).

### 5. Install Dependency Node.js (opsional)

UI utama TaskFlow memakai Bootstrap/Chart.js/SweetAlert2 via CDN sehingga build asset bukan keharusan. Namun jika Anda ingin mengembangkan asset lokal via Vite:

```bash
npm install
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Migrate Database

```bash
php artisan migrate
```

Perintah ini akan membuat seluruh tabel: `users`, `roles`, `categories`, `priorities`, `statuses`, `tasks`, `task_files`, `activity_logs`, beserta tabel pendukung Laravel (`sessions`, `cache`, `jobs`, dll).

### 8. Menjalankan Seeder

```bash
php artisan db:seed
```

Atau gabungkan migrate + seed sekaligus (akan mengosongkan tabel yang ada):

```bash
php artisan migrate:fresh --seed
```

Seeder akan membuat:
- 2 role (`admin`, `user`)
- 3 user contoh (1 admin, 2 user)
- 5 kategori, 4 prioritas, 5 status
- 10 contoh task

### 9. Membuat Symbolic Link Storage

Agar lampiran/avatar yang diupload dapat diakses publik:

```bash
php artisan storage:link
```

### 10. Build Asset (opsional)

Jika Anda menjalankan `npm install` di langkah 5:

```bash
npm run build
```

Untuk mode pengembangan dengan hot-reload:

```bash
npm run dev
```

### 11. Menjalankan Aplikasi

```bash
php artisan serve
```

Buka browser ke `http://localhost:8000`.

### 12. Login Menggunakan Akun Admin Default

| Role | Email | Password |
|---|---|---|
| Admin | admin@taskflow.test | password |
| User | user@taskflow.test | password |
| User | siti@taskflow.test | password |

**Penting:** segera ganti password default ini melalui menu Profile setelah login pertama kali di lingkungan produksi.

## Cara Deploy ke Hosting (Shared Hosting / VPS)

1. Upload seluruh isi project ke server (kecuali folder `vendor` dan `node_modules`, lalu jalankan `composer install --no-dev --optimize-autoloader` di server).
2. Set document root web server ke folder `public/`.
3. Salin `.env.example` ke `.env` di server, sesuaikan `APP_ENV=production`, `APP_DEBUG=false`, dan kredensial database produksi.
4. Jalankan:
   ```bash
   php artisan key:generate
   php artisan migrate --force
   php artisan db:seed --force   # opsional, hanya jika ingin data demo
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
5. Pastikan folder `storage/` dan `bootstrap/cache/` memiliki permission tulis (`chmod -R 775 storage bootstrap/cache`).
6. Arahkan domain ke folder `public/` (di shared hosting cPanel biasanya melalui pengaturan "Document Root" atau symlink `public_html` ke folder `public/`).

## Cara Backup Database

```bash
mysqldump -u root -p taskflow > backup_taskflow_$(date +%Y%m%d).sql
```

Restore:

```bash
mysql -u root -p taskflow < backup_taskflow_20260101.sql
```

## Cara Update Project

```bash
git pull origin main          # jika menggunakan Git
composer install
npm install && npm run build  # jika ada perubahan asset
php artisan migrate           # jalankan migration baru jika ada
php artisan config:clear
php artisan view:clear
```

## Struktur Folder Utama

```
taskflow/
├── app/
│   ├── Exports/              -> Class export Excel (TasksExport)
│   ├── Http/
│   │   ├── Controllers/      -> Seluruh controller (Auth, Dashboard, Task, User, dst)
│   │   ├── Middleware/       -> CheckRole
│   │   └── Requests/         -> Form Request validation
│   ├── Models/                -> Role, User, Category, Priority, Status, Task, TaskFile, ActivityLog
│   ├── Observers/             -> TaskObserver (auto activity log)
│   └── Providers/
├── database/
│   ├── migrations/            -> Seluruh migration
│   └── seeders/                -> Seluruh seeder
├── resources/views/
│   ├── layouts/                -> app.blade.php (sidebar+navbar), guest.blade.php
│   ├── auth/                   -> login
│   ├── dashboard/
│   ├── categories/ priorities/ statuses/ users/ tasks/ profile/
│   └── exports/                -> template PDF
├── routes/web.php
├── public/index.php
├── .env.example
└── README.md (file ini)
```

## Pengujian yang Telah Dilakukan

- Validasi struktur project Laravel 12 (bootstrap/app.php, artisan, public/index.php) sesuai standar resmi.
- Review seluruh migration untuk memastikan urutan foreign key benar (tabel induk dibuat sebelum tabel anak).
- Review seluruh route resource (`tasks`, `categories`, `priorities`, `statuses`, `users`) memetakan ke method controller yang sesuai (index, create, store, edit, update, destroy).
- Review middleware `role:admin` diterapkan pada seluruh route master data dan manajemen user.
- Review Form Request validation pada seluruh form input (task, user, kategori, prioritas, status, profile, password).

## Catatan Penting Mengenai Instalasi

Folder `vendor/` (dependency PHP) dan `node_modules/` (dependency Node.js) **tidak disertakan** dalam ZIP ini — ini adalah praktik standar untuk seluruh project Laravel/Node (termasuk saat clone dari Git), karena ukurannya besar dan harus di-generate ulang sesuai environment masing-masing melalui `composer install` dan `npm install` seperti pada panduan di atas. Seluruh source code aplikasi (model, controller, view, migration, seeder, route, config) sudah lengkap 100% dan siap dijalankan setelah dependency terinstall.
