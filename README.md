# SISPENDIK — Sistem Informasi Pendidikan
**SMK Assuniyah Tumijajar**

Aplikasi web manajemen pendidikan berbasis Laravel yang mencakup pendaftaran peserta didik baru (PPDB), manajemen siswa, nilai, jadwal pelajaran, dan notifikasi WhatsApp otomatis.

---

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: AdminLTE + Bootstrap 4 + Alpine.js
- **Database**: MySQL (utama) + SQLite (data wilayah)
- **Queue**: Laravel Queue (database driver)
- **PDF**: barryvdh/laravel-dompdf
- **WhatsApp**: Go WhatsApp API (Basic Auth)

---

## Persyaratan Sistem

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL / MariaDB

---

## Instalasi

### 1. Clone & Install Dependensi

```bash
git clone <repo-url>
cd sispendik
composer install
npm install && npm run build
```

### 2. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`, sesuaikan konfigurasi berikut:

```env
# Database Utama (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sispendik
DB_USERNAME=root
DB_PASSWORD=

# Queue Driver
QUEUE_CONNECTION=database

# WhatsApp API (Go WhatsApp)
WA_API_URL=https://wa-api.smkassuniyah.sch.id
WA_API_USERNAME=admin
WA_API_PASSWORD=your_password
```

### 3. Migrasi & Seeder

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

### 4. Buat Tabel Queue

```bash
php artisan queue:table
php artisan migrate
```

---

## Menjalankan Aplikasi

### Development (Lokal)

```bash
composer run dev
```

Akses di: **[http://localhost:8000](http://localhost:8000)**

### Production (Server)

Pastikan web server (Nginx/Apache) mengarah ke direktori `/public`.

Jalankan queue worker secara terus-menerus (gunakan `supervisor` di production):

```bash
php artisan queue:work --tries=3
```

---

## Default Login

Setelah menjalankan seeder:

| Role  | Email                  | Password   |
|-------|------------------------|------------|
| Admin | `admin@sispendik.com`  | `password` |

---

## Fitur Utama

### PPDB (Pendaftaran Peserta Didik Baru)
- Form pendaftaran multi-step dengan validasi
- Upload dokumen (KK, KTP, Akte, Ijazah)
- Kode referral
- Notifikasi WhatsApp otomatis setelah pendaftaran berhasil
- Generate & kirim PDF Formulir Pendaftaran via WhatsApp (diproses di background/queue)

### Manajemen Akademik
- Data siswa, kelas, dan tahun ajaran
- Input dan rekap nilai
- Jadwal pelajaran
- Manajemen guru/wali kelas

### Notifikasi WhatsApp
- Integrasi dengan Go WhatsApp API (Basic Auth)
- Pengiriman teks + file PDF
- Background job dengan auto-retry (3x, backoff 60 detik)

---

## Struktur Queue Job

| Job | Fungsi |
|-----|--------|
| `SendWhatsAppPendaftaranNotification` | Generate PDF Formulir Pendaftaran + Kirim WA (teks & PDF) |

---

## Database

Aplikasi menggunakan **dua** koneksi database:

| Koneksi | Driver | Fungsi |
|---------|--------|--------|
| `mysql` (default) | MySQL | Data utama aplikasi |
| `sqlite_wilayah` | SQLite | Referensi wilayah (Provinsi/Kabupaten/Kecamatan/Desa) |

File SQLite wilayah berada di: `database/factories/database.sqlite`  
*(tidak perlu dikonfigurasi ulang, sudah tersedia di repository)*

---

## Deployment Checklist

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan config:clear && php artisan view:clear && php artisan cache:clear
php artisan migrate --force
php artisan storage:link

# Pastikan permission storage benar
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Jalankan queue worker (atau restart supervisor)
php artisan queue:work --tries=3
```
