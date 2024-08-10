# Aplikasi E-Office

## Gambaran Umum

E-Office (Electronic Office) adalah sistem manajemen perkantoran elektronik yang dikembangkan menggunakan bahasa pemograman PHP dan framework Laravel. Aplikasi ini dirancang untuk memudahkan pengelolaan surat masuk dan surat keluar, dengan fokus pada pengarsipan dan pelacakan surat.

## Fitur

- **Manajemen Surat Masuk**: Mengelola dan mengarsipkan surat masuk dengan efisien.
- **Manajemen Surat Keluar**: Mengelola dan melacak surat keluar.
- **Manajemen Laporan**: Menghasilkan laporan surat masuk dan surat keluar sesuai kriteria tertentu.
- **Pencarian dan Pengambilan**: Menemukan arsip surat dengan cepat menggunakan fitur pencarian yang canggih.
- **Peran dan Izin Pengguna**: Menentukan peran dan izin untuk mengontrol akses dan tindakan dalam sistem.
- **Dashboard dan Widget**: Menghasilkan laporan dan melihat statistik aktivitas manajemen surat.
- **Sistem Notifikasi**: Menerima notifikasi untuk kejadian dan tenggat waktu surat yang penting.

## Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- SQLite 
- Node.js dan npm (untuk kompilasi aset front-end)

### Langkah-langkah

1. **Clone Repositori**
   ```bash
   git clone https://github.com/frizcool/office.git
   cd office
   ```

2. **Install Dependensi**
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. **Konfigurasi Lingkungan**
   Salin file `.env.example` menjadi `.env` dan atur kredensial database serta variabel lingkungan lainnya.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi dan Seed Database**
   Jalankan migrasi dan seed database dengan data awal.
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   Mulai server pengembangan Laravel.
   ```bash
   php artisan serve
   ```

## Penggunaan

Setelah instalasi, Anda dapat mengakses aplikasi dengan menavigasi ke `http://localhost:8000` di peramban web Anda. Masuk dengan kredensial admin default yang disediakan di database seeder.

### Panel Admin

Panel admin dibangun menggunakan Filament PHP, menyediakan antarmuka intuitif untuk mengelola pengguna, peran, izin, dan catatan surat. Anda dapat mengakses panel admin di `http://localhost:8000`.


## Kontak

Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami di support@eoffice.com.


## Biodata Programmer
<img src="https://deptmin.frideoo.com/storage/csgt_fris_wardani.jpg" alt="Fris Wardani's Profile Image" style="width: 200px;"/>

Nama: Fris Wardani, S.Kom.  
Pangkat: Serka  
NRP: 21110057040790  
Kesatuan: Infolahtadam III/Slw  
Email: friswardani90@gmail.com atau support@frideoo.com
