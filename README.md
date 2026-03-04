# Panduan Instalasi Project

Dokumentasi ini berisi langkah-langkah untuk melakukan instalasi dan menjalankan aplikasi web ini di komputer lokal (localhost).

## Persyaratan Sistem

Pastikan sistem Anda telah terinstal software berikut:
- **PHP** versi 8.2 atau yang lebih baru
- **Composer** (untuk dependensi PHP)
- **Node.js & NPM** (untuk dependensi Frontend)
- *(Opsional)* **MySQL / MariaDB** (jika ingin menggunakan MySQL, defaultnya adalah SQLite)

---

## Langkah Instalasi

### 1. Ekstrak / Buka Project
Pastikan Anda sudah mengekstrak kode sumber dan membuka terminal (Command Prompt / PowerShell / Git Bash) tepat berada di dalam direktori utama project (contoh: `d:\CODE\sispendik\sispendik`).

### 2. Jalankan Setup Otomatis
Project ini telah memiliki skrip instalasi untuk mempermudah pengaturan awal. Jalankan perintah berikut di terminal:

```bash
composer run setup
```

**Perintah di atas akan mengeksekusi proses secara otomatis:**
1. Mengunduh semua paket `vendor` PHP (`composer install`).
2. Menyalin file konfigurasi `.env.example` menjadi `.env`.
3. Men-generate Application Key (`php artisan key:generate`).
4. Menjalankan migrasi database ke database default (`php artisan migrate`).
5. Mengunduh paket `node_modules` (`npm install`).
6. Melakukan build asset frontend (`npm run build`).

### 3. Konfigurasi Database (Penting!)
Aplikasi ini menggunakan **dua** jenis database:
1. **MySQL** sebagai database utama aplikasi.
2. **SQLite** khusus untuk referensi data wilayah (Provinsi, Kabupaten, dll).

**Langkah Konfigurasi MySQL:**
1. Buka file `.env`.
2. Pastikan konfigurasi DB telah menggunakan MySQL, contohnya:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Pastikan Anda telah membuat database kosong di phpMyAdmin atau MySQL dengan nama `nama_database_anda`)*.
3. Jalankan perintah migrasi dan seeder untuk database utama:
   ```bash
   php artisan migrate:fresh --seed
   ```

**Langkah Konfigurasi SQLite Wilayah (Otomatis):**
Aplikasi secara otomatis membaca database SQLite untuk data wilayah di path `database/factories/database.sqlite`. Anda tidak perlu melakukan konfigurasi `.env` tambahan untuk ini.

### Default Login (Admin)
Secara bawaan, setelah Anda menjalankan `php artisan migrate:fresh --seed`, tersedia satu akun administrator untuk keperluan _testing_:
- **Email:** `admin@sispendik.com`
- **Password:** `password`

---

## Menjalankan Aplikasi

Terdapat dua skenario untuk menjalankan aplikasi: **Development** (untuk masa pengembangan/lokal) dan **Production** (untuk server/hosting publik).

### Mode Development (Lokal)
Jika Anda hanya ingin menjalankan server di komputer untuk tes/ngoding, gunakan perintah:
```bash
composer run dev
```

Perintah di atas secara otomatis akan menghidupkan **Laravel Server** sekaligus **Vite Server**.
Sekarang, Anda bisa membuka browser dan mengakses website melalui:
👉 **[http://localhost:8000](http://localhost:8000)**

### Mode Production (Server/Hosting)
Jika aplikasi sudah siap dionline-kan atau dipindah ke server publik, Vite Server (dari Node) tidak perlu (dan tidak boleh) dihidupkan secara terus-menerus. Aset frontend cukup di-build sekali.
1. Pastikan Anda telah menjalankan build (ini sudah otomatis dijalankan jika menggunakan `composer run setup`):
   ```bash
   npm run build
   ```
2. Aplikasi siap diakses melalui web server (misal: Apache / Nginx) dengan meletakkan _document root_ mengarah ke direktori `/public` project ini.
