# Aplikasi E-Office

## Gambaran Umum

E-Office (Electronic Office) adalah sistem manajemen perkantoran elektronik yang dikembangkan menggunakan Laravel dan Filament PHP. Aplikasi ini dirancang untuk memudahkan pengelolaan surat masuk dan surat keluar, dengan fokus pada pengarsipan dan pelacakan surat.

## Fitur

- **Manajemen Surat Masuk**: Mengelola dan mengarsipkan surat masuk dengan efisien.
- **Manajemen Surat Keluar**: Mengelola dan melacak surat keluar.
- **Pencarian dan Pengambilan**: Menemukan arsip surat dengan cepat menggunakan fitur pencarian yang canggih.
- **Peran dan Izin Pengguna**: Menentukan peran dan izin untuk mengontrol akses dan tindakan dalam sistem.
- **Dashboard dan Pelaporan**: Menghasilkan laporan dan melihat statistik aktivitas manajemen surat.
- **Sistem Notifikasi**: Menerima notifikasi untuk kejadian dan tenggat waktu surat yang penting.

## Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- SQLite (atau database lain yang didukung)
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

Panel admin dibangun menggunakan Filament PHP, menyediakan antarmuka intuitif untuk mengelola pengguna, peran, izin, dan catatan surat. Anda dapat mengakses panel admin di `http://localhost:8000/admin`.

## Kontribusi

Kami menyambut kontribusi dari komunitas! Untuk berkontribusi, ikuti langkah-langkah berikut:

1. Fork repositori ini.
2. Buat cabang baru (`git checkout -b fitur/nama-fitur-anda`).
3. Lakukan perubahan dan commit (`git commit -m 'Tambah fitur tertentu'`).
4. Push ke cabang (`git push origin fitur/nama-fitur-anda`).
5. Buka Pull Request.

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT - lihat file [LICENSE](LICENSE) untuk detailnya.

## Kontak

Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami di support@eoffice.com.

---

Terima kasih telah menggunakan E-Office! Kami berharap aplikasi ini dapat membantu mempermudah proses manajemen perkantoran Anda.

## Biodata Programmer

**Nama:** Fris Wardani, S.Kom.  
**Pangkat:** Serka  
**NRP:** 21110057040790  
**Kesatuan:** Infolahtadam III/Slw