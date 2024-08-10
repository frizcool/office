<x-filament-panels::page>
    <style>
        /* Gaya untuk daftar terurut */
        .custom-ol {
            list-style-type: decimal;
            padding-left: 20px;
        }

        /* Gaya untuk daftar tidak terurut */
        .custom-ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        /* Gaya untuk blok kode */
        .code-block {
            /* background-color: #f4f4f4; */
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            overflow-x: auto;
            font-family: monospace;
        }

        /* Tombol salin */
        .copy-button {
            /* background-color: #007bff;
            color: white; */
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }
        .bio-container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap; /* Membolehkan elemen untuk membungkus jika ruang terbatas */
        }

        .bio-photo {
            flex: 1;
            max-width: 200px; /* Sesuaikan dengan ukuran yang diinginkan */
        }

        .bio-photo img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .bio-description {
            flex: 2;
        }

        /* Media query untuk tampilan mobile */
        @media (max-width: 768px) {
            .bio-container {
                flex-direction: column; /* Menyusun elemen secara vertikal pada perangkat seluler */
                align-items: left; /* Menyusun elemen di tengah secara horizontal */
            }

            .bio-photo, .bio-description {
                max-width: 100%; /* Memastikan foto dan deskripsi tidak melebihi lebar kontainer */
            }
        }

        .copy-button:hover {
            /* background-color: #0056b3; */
        }

    </style> 
    
    <x-filament::section>
        <x-slot name="heading">
            Gambaran Umum
        </x-slot>
        <strong class="text-primary-500">E-Office (Electronic Office)</strong> adalah sistem manajemen perkantoran elektronik yang dikembangkan menggunakan bahasa pemograman PHP dan framework Laravel. Aplikasi ini dirancang untuk memudahkan pengelolaan surat masuk dan surat keluar, dengan fokus pada pengarsipan dan pelacakan surat.
    </x-filament::section>
    <x-filament::section>
        <x-slot name="heading">
            Fitur
        </x-slot>
        <ul class="custom-ul">
            <li><strong>Manajemen Surat Masuk:</strong> Mengelola dan mengarsipkan surat masuk dengan efisien.</li>
            <li><strong>Manajemen Surat Keluar:</strong> Mengelola dan melacak surat keluar.</li>
            <li><strong>Manajemen Laporan:</strong> Menghasilkan laporan surat masuk dan surat keluar sesuai kriteria tertentu.</li>
            <li><strong>Pencarian dan Pengambilan:</strong> Menemukan arsip surat dengan cepat menggunakan fitur pencarian yang canggih.</li>
            <li><strong>Peran dan Izin Pengguna:</strong> Menentukan peran dan izin untuk mengontrol akses dan tindakan dalam sistem.</li>
            <li><strong>Dashboard dan Widget:</strong> Menghasilkan laporan dan melihat statistik aktivitas manajemen surat.</li>
            <li><strong>Sistem Notifikasi:</strong> Menerima notifikasi untuk kejadian dan tenggat waktu surat yang penting.</li>
        </ul>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            Instalasi
        </x-slot>
        <x-filament::section>
            <x-slot name="heading">
                Prasyarat
            </x-slot>
            <ul class="custom-ul">
                <li>PHP >= 8.2</li>
                <li>Composer</li>
                <li>SQLite</li>
                <li>Node.js dan npm (untuk kompilasi aset front-end)</li>
            </ul>
        </x-filament::section>
<br>
        <x-filament::section>
            <x-slot name="heading">
                Langkah-langkah
            </x-slot>
            <ol class="custom-ol">
                <li><strong>Clone Repositori:</strong>
                    <div class="code-block">
                        <pre><code>git clone https://github.com/frizcool/office.git
cd office</code></pre>
                    </div>
                </li>
                <li><strong>Install Dependensi:</strong>
                    <div class="code-block">
                        <pre><code>composer install
npm install
npm run dev</code></pre>
                    </div>
                </li>
                <li><strong>Konfigurasi Lingkungan:</strong>
                    Salin file `.env.example` menjadi `.env` dan atur kredensial database serta variabel lingkungan lainnya.
                    <div class="code-block">
                        <pre><code>cp .env.example .env
php artisan key:generate</code></pre>
                    </div>
                </li>
                <li><strong>Migrasi dan Seed Database:</strong>
                    Jalankan migrasi dan seed database dengan data awal.
                    <div class="code-block">
                        <pre><code>php artisan migrate --seed</code></pre>
                    </div>
                </li>
                <li><strong>Jalankan Aplikasi:</strong>
                    Mulai server pengembangan Laravel.
                    <div class="code-block">
                        <pre><code>php artisan serve</code></pre>
                    </div>
                </li>
            </ol>
        </x-filament::section>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            Penggunaan
        </x-slot>
        Setelah instalasi, Anda dapat mengakses aplikasi dengan menavigasi ke <a href="http://localhost:8000">http://localhost:8000</a> di peramban web Anda. Masuk dengan kredensial admin default yang disediakan di database seeder.
<br><br>
        <x-filament::section>
            <x-slot name="heading">
                Panel Admin
            </x-slot>
            Panel admin dibangun menggunakan Filament PHP, menyediakan antarmuka intuitif untuk mengelola pengguna, peran, izin, dan catatan surat. Anda dapat mengakses panel admin di <a href="http://localhost:8000">http://localhost:8000</a>.
        </x-filament::section>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            Tentang saya
        </x-slot>
        <div class="bio-container">
            <div class="bio-photo">
                <img src="https://deptmin.frideoo.com/storage/csgt_fris_wardani.jpg" alt="Foto Fris Wardani">
            </div>
            <div class="bio-description">
                <p><strong>Nama</strong><br> &nbsp;&nbsp;&nbsp; Fris Wardani, S.Kom.</p>
                <p><strong>Pangkat</strong><br> &nbsp;&nbsp;&nbsp; Serka</p>
                <p><strong>NRP</strong><br> &nbsp;&nbsp;&nbsp; 21110057040790</p>
                <p><strong>Kesatuan</strong><br> &nbsp;&nbsp;&nbsp; Infolahtadam III/Slw</p>
                <p><strong>Email</strong><br> &nbsp;&nbsp;&nbsp; friswardani90@gmail.com</p>
            </div>
        </div>
        <br>
        <x-filament::fieldset>
            <x-slot name="label">
                Pengalaman
            </x-slot>
            <ul class="custom-ul">   
                <li>Fullstack Developer aplikasi <strong class="text-primary-500">Latihan untuk Posko Kodam III</strong> (2016-Sekarang)</li>
                <li>Fullstack Developer aplikasi <strong class="text-primary-500">Sisfo Pussenarmed</strong> (2018-2021)</li>
                <li>Web Developer dan Administrator di 20+ Website Kotama dan Balakpus (2018-Sekarang)</li>
                <li>Fullstack Developer aplikasi <strong class="text-primary-500">Babinsa Kodim Situbondo</strong> (2021-2022)</li>
                <li>Fullstack Developer aplikasi <strong class="text-primary-500">Kompers Sperdam III/Slw</strong> (2021-2022)</li>
                <li>Fullstack Developer aplikasi <strong class="text-primary-500">Dosir Elektronik Ajendam III/Slw</strong> (2022-Sekarang)</li>
                <li>Fullstack Developer aplikasi <strong class="text-primary-500">Sisfo <i>Administrative Department of Force Headquarter Support Unit UNIFIL</i></strong> (2023-Sekarang)</li>
                <li>Fullstack Developer aplikasi <strong class="text-primary-500">Dosir Elektronik Ajendam II/Swj</strong> (2024-Sekarang)</li>
            </ul>
        </x-filament::fieldset>

    </x-filament::section>

    <script>
        function copyToClipboard(text) {
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert('Kode telah disalin ke clipboard!');
        }
    </script>
</x-filament-panels::page>
