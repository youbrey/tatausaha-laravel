# SIPS — Laravel Edition

Sistem Informasi Persuratan DPRD, versi Laravel (modular, dipisah per fungsi/komponen).
Dirancang untuk berjalan di **XAMPP lokal**, dengan opsi deploy ke hosting gratis pembelajaran.

## Struktur Folder (poin penting)

```
app/
  Models/                  → Eloquent model: User, Surat, PersonelDPRD, PersonelASN, dst
  Services/
    NomorSuratService.php       → logika penomoran otomatis surat
    TanggalIndonesiaService.php → format tanggal Bahasa Indonesia
    DocumentGenerator/
      BaseDocumentGenerator.php → kelas dasar generator Word
      SuratTugasGenerator.php
      SppdGenerator.php
      UndanganGenerator.php
      DocumentGeneratorFactory.php
  Http/Controllers/
    DashboardController.php
    PersonelController.php
    Surat/PerjalananDinasController.php
    Surat/UndanganController.php

resources/views/
  layouts/app.blade.php       → kerangka halaman utama
  components/                 → sidebar, topbar, tabel pelaksana (reusable)
  surat/perjalanan-dinas/     → form & preview surat tugas/SPPD
  surat/undangan/             → form & preview undangan
  personel/                   → CRUD data personel
  dashboard/                  → halaman utama

storage/app/templates/        → MASTER TEMPLATE WORD (.docx) — ganti file ini sesuai kop surat asli kamu
storage/app/output/           → file hasil generate (sementara, otomatis terhapus setelah download)

database/migrations/          → struktur tabel (mengikuti schema project Next.js kamu)
config/sips.php               → pengaturan khusus SIPS (nama instansi, jenis surat, prefix nomor)
routes/web.php                → semua rute aplikasi
```

## Setup di XAMPP (Lokal)

1. **Copy folder** `sips-laravel` ke `C:\xampp\htdocs\` (atau folder htdocs kamu).

2. **Install Composer** (jika belum ada): https://getcomposer.org/download/

3. Buka terminal/CMD di folder project, jalankan:
   ```bash
   composer install
   ```
   Ini akan download Laravel framework, PhpWord, dan semua dependency dari `composer.json`.

4. **Copy file environment:**
   ```bash
   copy .env.example .env
   ```
   (Linux/Mac: `cp .env.example .env`)

5. **Generate APP_KEY:**
   ```bash
   php artisan key:generate
   ```

6. **Buat database** lewat phpMyAdmin (http://localhost/phpmyadmin), nama: `sips_db`
   Sesuaikan `.env` jika nama/host/port database kamu berbeda.

7. **Jalankan migration:**
   ```bash
   php artisan migrate
   ```

8. **Isi data awal (akun admin):**
   ```bash
   php artisan db:seed
   ```
   Login default: `admin@sips.local` / `password123` — **ganti setelah login pertama kali.**

9. **Jalankan server:**
   ```bash
   php artisan serve
   ```
   Buka http://localhost:8000

   *(Atau kalau pakai Apache bawaan XAMPP langsung: arahkan virtual host ke folder `public/`)*

## Mengganti Master Template Surat

File di `storage/app/templates/*.docx` adalah **placeholder** — bukan template asli instansi kamu.
Untuk menggunakan kop surat & format resmi DPRD kamu:

1. Buka file `.docx` template asli kamu di Microsoft Word.
2. Di posisi yang datanya harus otomatis terisi, ganti teks dengan placeholder format `${nama_field}`,
   contoh: `${nomor_surat}`, `${nama_ttd}`, `${tanggal_pelaksanaan}`.
3. Untuk tabel (daftar pelaksana), beri placeholder `${no}`, `${nama_pelaksana}`, `${jabatan_pelaksana}`
   pada **satu baris saja** — sistem akan otomatis menggandakan baris itu sesuai jumlah data (`cloneRow`).
4. Simpan file dengan nama yang sama, replace file lama di `storage/app/templates/`.
5. Daftar placeholder yang dipakai tiap jenis surat ada di method `mapData()` pada masing-masing
   class di `app/Services/DocumentGenerator/`.

## Catatan

- Generator dokumen pakai library **PhpOffice/PhpWord** (`TemplateProcessor`), prinsipnya sama seperti
  `docxtemplater` yang dipakai di versi Next.js kamu, atau `python-docx` di versi desktop Python.
- Setiap jenis surat punya class generator sendiri (`SuratTugasGenerator`, `SppdGenerator`, `UndanganGenerator`)
  supaya kalau salah satu format berubah, tidak menyentuh kode jenis surat lain.
- Untuk deploy ke hosting gratis (pembelajaran), pastikan hosting punya: PHP ≥8.1, akses Composer/SSH,
  dan MySQL. Banyak free-host PHP murni (tanpa SSH) **tidak bisa** menjalankan Laravel.
