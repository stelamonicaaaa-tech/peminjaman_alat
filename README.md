<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# 🚀 Cara Menjalankan Project Laravel dari GitHub di Laragon

## 📋 Langkah-langkah Lengkap

---

## METODE 1: Clone via Terminal Laragon (Recommended)

### Step 1: Buka Terminal Laragon
Klik kanan icon Laragon → **Terminal**

### Step 2: Masuk ke Folder www
```bash
cd C:\laragon\www
```

### Step 3: Clone Repository
```bash
git clone https://github.com/alfisyukri422-web/peminjaman_alat.git
```

**Contoh:**
```bash
git clone https://github.com/alfisyukri422/peminjaman_alat.git
```

### Step 4: Masuk ke Folder Project
```bash
cd peminjaman_alat
```

**Contoh:**
```bash
cd peminjaman_alat
```

### Step 5: Install Dependencies
```bash
composer install
```

*Tunggu hingga selesai (2-5 menit)*

### Step 6: Install Node Dependencies (jika ada)
```bash
npm install
# atau
npm install --legacy-peer-deps
```

### Step 7: Copy File .env
```bash
copy .env.example .env
```

### Step 8: Generate Application Key
```bash
php artisan key:generate
```

### Step 9: Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Peminjaman_alat
DB_USERNAME=root
DB_PASSWORD=
```

### Step 10: Buat Database
1. Buka HeidiSQL (Laragon → Database → HeidiSQL)
2. Klik kanan → Create new → Database
3. Nama: `Peminjaman_alat` (sesuai .env)
4. Klik OK

### Step 11: Jalankan Migration
```bash
php artisan migrate
```

**Atau jika ada file SQL:**
1. Buka HeidiSQL
2. Pilih database yang baru dibuat
3. File → Load SQL file
4. Pilih file .sql
5. Execute (F9)

### Step 12: Jalankan Seeder (jika ada)
```bash
php artisan db:seed
```

### Step 13: Create Storage Link
```bash
php artisan storage:link
```

### Step 14: Clear Cache
```bash
php artisan optimize:clear
```

### Step 15: Akses Website
Buka browser: **http://nama-folder.test**

**Contoh:**
- http://peminjaman-alat.test

**Jika tidak bisa:**
- http://localhost/nama-folder/public

---

## METODE 2: Download ZIP dari GitHub

### Step 1: Download Project
1. Buka repository di GitHub
2. Klik tombol **Code** (hijau)
3. Klik **Download ZIP**
4. Extract ZIP ke folder `C:\laragon\www\`

### Step 2: Rename Folder
Rename folder hasil extract (hilangkan `-main` atau `-master`)

**Contoh:**
- Dari: `peminjaman-alat-main`
- Jadi: `peminjaman-alat`

### Step 3: Buka Terminal
Klik kanan icon Laragon → Terminal

### Step 4: Masuk ke Folder Project
```bash
cd C:\laragon\www\nama-folder
```

### Step 5: Lanjutkan dari Step 5 Metode 1
(Install composer, copy .env, dst...)

---

## 📝 CHECKLIST INSTALASI

```
✅ Clone/Download project dari GitHub
✅ Masuk ke folder project
✅ composer install
✅ npm install (jika ada package.json)
✅ copy .env.example .env
✅ php artisan key:generate
✅ Edit .env (database config)
✅ Buat database di HeidiSQL
✅ php artisan migrate (atau import SQL)
✅ php artisan db:seed (jika ada)
✅ php artisan storage:link
✅ php artisan optimize:clear
✅ Akses di browser
```

---

## 🔧 TROUBLESHOOTING

### Error: "composer: command not found"
```bash
# Restart terminal Laragon atau
# Pastikan Composer terinstall di Laragon
```

### Error: "Class not found"
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [1049] Unknown database"
```
Buat database dulu di HeidiSQL sesuai nama di .env
```

### Error: "permission denied" (folder storage/logs)
```bash
# Windows - Di terminal Laragon:
mkdir storage\logs
mkdir storage\framework\cache
mkdir storage\framework\sessions
mkdir storage\framework\views

# Atau buat manual via File Explorer
```

### Error: Virtual host tidak bisa diakses
**Solusi 1: Restart Laragon**
- Stop All
- Start All

**Solusi 2: Akses via localhost**
- http://localhost/nama-folder/public

**Solusi 3: Edit hosts file**
1. Buka Notepad sebagai Administrator
2. Buka file: `C:\Windows\System32\drivers\etc\hosts`
3. Tambahkan: `127.0.0.1 nama-folder.test`
4. Save
5. Restart browser

### Error: npm install gagal
```bash
# Coba dengan flag legacy
npm install --legacy-peer-deps

# Atau hapus node_modules dan coba lagi
rmdir /s node_modules
del package-lock.json
npm install
```

### Error: Vite not found / npm run dev error
```bash
npm install
npm run build
```

---

## 📦 STRUKTUR PROJECT LARAVEL DARI GITHUB

Biasanya project Laravel dari GitHub akan memiliki:

```
nama-project/
├── .env.example          ← Template konfigurasi
├── composer.json         ← Dependencies PHP
├── package.json          ← Dependencies Node (optional)
├── database/
│   ├── migrations/       ← File migration
│   └── seeders/          ← File seeder
├── app/
├── routes/
├── resources/
└── public/
```

**Yang TIDAK ada di GitHub:**
- `.env` (harus copy dari .env.example)
- `vendor/` (harus install via composer)
- `node_modules/` (harus install via npm)

---

## 🎯 TIPS PENTING

### 1. Selalu Baca README.md
Buka file `README.md` di repository GitHub untuk instruksi spesifik project tersebut.

### 2. Cek File .env.example
Lihat konfigurasi apa saja yang diperlukan:
- Database name
- API keys
- Storage settings
- dll

### 3. Cek composer.json
Lihat versi PHP yang dibutuhkan:
```json
"require": {
    "php": "^8.2",
    ...
}
```

### 4. Perhatikan Dependencies
Beberapa project butuh:
- Redis
- Queue worker
- Node.js untuk Vite/Mix
- Extensions PHP tertentu

### 5. Migration vs SQL File
**Jika ada folder `database/migrations/`:**
```bash
php artisan migrate
php artisan db:seed
```

**Jika ada file `.sql`:**
- Import via HeidiSQL

---

## 🚀 QUICK COMMAND REFERENCE

```bash
# Clone project
git clone URL-REPOSITORY
cd nama-folder

# Install dependencies
composer install
npm install

# Setup environment
copy .env.example .env
php artisan key:generate

# Database (pilih salah satu)
php artisan migrate          # Via migration
# atau import SQL via HeidiSQL

# Seed data
php artisan db:seed

# Create storage link
php artisan storage:link

# Clear cache
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build assets (jika pakai Vite/Mix)
npm run build
# atau untuk development
npm run dev
```

---

## 📌 CONTOH LENGKAP

### Clone Project "peminjaman-alat"

```bash
# 1. Buka terminal Laragon
cd C:\laragon\www

# 2. Clone
git clone https://github.com/john/peminjaman-alat.git
cd peminjaman-alat

# 3. Install
composer install

# 4. Setup
copy .env.example .env
php artisan key:generate

# 5. Edit .env
# DB_DATABASE=peminjaman_alat

# 6. Buat database "peminjaman_alat" di HeidiSQL

# 7. Import SQL (jika ada file .sql)
# Atau jalankan migration:
php artisan migrate
php artisan db:seed

# 8. Finishing
php artisan storage:link
php artisan optimize:clear

# 9. Akses
# http://peminjaman-alat.test
```

---

## ⚡ LARAGON SPECIFIC TIPS

### Pretty URLs
Laragon otomatis membuat virtual host dengan format:
```
http://nama-folder.test
```

### Database Tool
HeidiSQL sudah built-in:
- Klik kanan Laragon → Database → HeidiSQL
- Default: username `root`, password kosong

### SSL Certificate
Untuk HTTPS:
- Klik kanan Laragon → Apache → SSL → nama-folder.test
- Akses: https://nama-folder.test

### Quick Terminal
- Klik kanan Laragon → Terminal
- Sudah include PHP, Composer, Git, Node

### Stop/Start Services
- Klik kanan icon → Stop All
- Klik kanan icon → Start All

---

## 🎓 BEST PRACTICES

### 1. Gunakan Git Branch
```bash
git checkout -b development
# Jangan langsung edit di branch main
```

### 2. Backup Database
Sebelum migrate:
```bash
# Export database dulu via HeidiSQL
```

### 3. Cek Versi PHP
```bash
php -v
# Pastikan sesuai requirement project
```

### 4. Update Composer
```bash
composer update
# Hanya jika diperlukan
```

### 5. Dokumentasi
Buat catatan perubahan konfigurasi yang Anda lakukan.

---

## ❓ FAQ

**Q: Kenapa composer install lama?**
A: Tergantung dependencies. Bisa 2-10 menit. Pastikan koneksi internet stabil.

**Q: Harus install npm?**
A: Hanya jika project pakai Vite/Laravel Mix (ada file package.json).

**Q: Database sudah ada, tetap migrate?**
A: Jika ada data, jangan migrate. Import SQL saja.

**Q: Error 500 setelah clone?**
A: Cek .env, pastikan APP_KEY ada. Jalankan `php artisan key:generate`.

**Q: Folder vendor tidak ada?**
A: Normal. Harus install via `composer install`.

---

## ✅ SELESAI!

Project Laravel dari GitHub sekarang sudah bisa dijalankan di Laragon! 🎉

**Untuk project peminjaman-alat:**
- Login: sesuai database atau buat via `php artisan db:seed`
- Atau register manual di /register

Semoga membantu! 🚀




Cara Install Laravel dari GitHub di XAMPP - SINGKAT
✅ PERSIAPAN
Install dulu:
XAMPP - https://www.apachefriends.org/
Composer - https://getcomposer.org/
Git (optional) - https://git-scm.com/
📦 LANGKAH INSTALL
1. Clone Project
# Buka CMD
cd C:\xampp\htdocs

# Clone
git clone https://github.com/username/peminjaman_alat.git

# Masuk folder
cd peminjaman_alat
Atau download ZIP:
Download dari GitHub → Extract ke C:\xampp\htdocs\
2. Install Dependencies
composer install
npm install
Tunggu 2-5 menit
3. Setup Environment
copy .env.example .env
php artisan key:generate
Edit file .env:
DB_DATABASE=peminjaman_alat
DB_USERNAME=root
DB_PASSWORD=
Password kosong untuk XAMPP
4. Nyalakan XAMPP
Buka XAMPP Control Panel
Start Apache & MySQL (tunggu jadi hijau)
5. Buat Database
Buka browser: http://localhost/phpmyadmin
Klik Databases → Buat database: peminjaman_alat
6. Migration & Setup
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan optimize:clear
7. Jalankan Website
Buka browser:
http://localhost/peminjaman_alat/public
SELESAI! 🎉
⚡ QUICK COMMANDS
# Satu baris install
composer install && npm install && copy .env.example .env && php artisan key:generate

# Setup database
php artisan migrate && php artisan db:seed

# Clear everything
php artisan optimize:clear
🔧 ERROR? COBA INI
Apache gak bisa start:
Port 80 bentrok → Matikan Skype/program lain
Composer not found:
Install Composer → Restart CMD
Database error:
Cek MySQL XAMPP nyala (hijau)
Cek nama database di .env sama dengan phpMyAdmin
Error 500:
php artisan key:generate
php artisan config:clear
📌 STRUKTUR FOLDER
C:\xampp\htdocs\peminjaman_alat\
    ├── .env              ← Konfigurasi
    ├── vendor/           ← Hasil composer install
    ├── public/           ← Akses via browser
    └── database/
        └── migrations/   ← Bikin tabel
