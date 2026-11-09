# NFS Web Studio

Website layanan pembuatan website berbasis Laravel 12, Blade, Tailwind CSS 4, Vite, dan Alpine.js. Konten layanan, paket, klien, proyek, testimoni, FAQ, dan pengaturan kontak dikelola melalui database MySQL dan panel admin.

## Kebutuhan

- PHP 8.2 atau lebih baru beserta ekstensi Laravel yang diperlukan
- Composer
- Node.js dan npm
- MySQL 8+ atau MariaDB yang kompatibel (misalnya melalui Laragon/XAMPP)

## Instalasi Lokal

1. Buat database MySQL `web_agency` dengan charset `utf8mb4`.
2. Pasang dependensi PHP dan JavaScript:

   ```sh
   composer install
   npm install
   ```

3. Salin `.env.example` menjadi `.env`, lalu isi koneksi database dan nilai rahasia admin. Pastikan `MAIL_MAILER=log` jika SMTP belum dikonfigurasi.
4. Buat application key, siapkan skema, dan isi data awal:

   ```sh
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

5. Jalankan Vite dan Laravel di dua terminal:

   ```sh
   npm run dev
   php artisan serve
   ```

   Buka `http://127.0.0.1:8000`.

Untuk membuat ulang database lokal dari awal, gunakan `php artisan migrate:fresh --seed`. Perintah ini menghapus seluruh tabel pada koneksi database yang sedang dipilih.

## Panel Admin

- Login: `/admin/login` (URL dasar lokal: `http://127.0.0.1:8000/admin/login`)
- Email dan password admin diambil dari `ADMIN_SEED_EMAIL` dan `ADMIN_SEED_PASSWORD` pada `.env`.
- Ganti password seed lokal dengan nilai kuat sebelum menjalankan seeder dan jangan menggunakan kredensial lokal untuk produksi.
- Panel menyediakan pengelolaan layanan, paket beserta fiturnya, klien, proyek, testimoni, FAQ, pengaturan situs, dan inquiry.
- Berkas logo serta thumbnail disimpan pada storage publik; jalankan `php artisan storage:link`.

## Email Formulir Kontak

Notifikasi inquiry dikirim melalui Laravel Mail ke `MAIL_NOTIFICATION_TO`. Tanpa SMTP, gunakan `MAIL_MAILER=log` agar pesan tercatat pada log aplikasi tanpa memerlukan server email. Untuk SMTP, isi variabel `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, dan konfigurasi mail terkait di `.env`.

## Build Produksi

```sh
npm run build
php artisan route:list
php artisan migrate:status
```

Pastikan `APP_DEBUG=false`, gunakan HTTPS, atur kredensial produksi di environment server, dan jangan unggah `.env` atau `node_modules`.

## Environment Vercel

`vercel.env.example` adalah template untuk mengisi Environment Variables di pengaturan proyek Vercel. Project ref `rxnwprsmicroswahizwj` sudah diisi dari URL API Supabase. Ganti `APP_KEY`, `URL_ENCODED_DATABASE_PASSWORD`, dan `POOLER_HOST` menggunakan nilai rahasia dan host dari proyek Supabase Anda. Buat `APP_KEY` unik dengan `php artisan key:generate --show`; jangan commit atau membagikan key tersebut. Gunakan transaction pooler Supabase untuk trafik serverless. Untuk menjalankan migration, gunakan koneksi direct atau session pooler sementara dari mesin deployment/admin; jangan gunakan `migrate:fresh` pada database production.

Aplikasi menggunakan PostgreSQL Supabase untuk database. Jalankan `php artisan migrate --force` terhadap database itu sebelum menerima trafik. `FILESYSTEM_DISK=local` tidak persisten di Vercel; upload logo/thumbnail membutuhkan object storage dan penyesuaian konfigurasi disk aplikasi. `MAIL_MAILER=log` tidak mengirim email; atur SMTP provider jika notifikasi inquiry harus diterima.

Repository ini menggunakan `vercel-php` untuk menjalankan Laravel sebagai PHP Function. Pengaturan proyek Vercel:

1. Framework Preset: **Other**.
2. Build Command: `npm run build`.
3. Output Directory: `public`.
4. Node.js Version: **22.x**.
5. Tambahkan Environment Variables dari `vercel.env.example` untuk Production, Preview, dan Development sesuai kebutuhan. Jangan mengunggah file `vercel.env`.

`vercel.json` mengirim permintaan yang bukan berkas statis ke `api/index.php`. Laravel memakai direktori sementara `/tmp` untuk data runtime yang dapat ditulis; direktori ini tidak persisten. Migrasi production harus dijalankan secara terpisah setelah kompatibilitas PostgreSQL dan koneksi Supabase dikonfirmasi.

## Pindah dari Lokal ke Online

1. Siapkan hosting yang mendukung Laravel/PHP dan PostgreSQL, lalu arahkan DNS domain ke hosting.
2. Atur `APP_URL` ke URL HTTPS domain final, `APP_ENV=production`, `APP_DEBUG=false`, dan konfigurasi database/email produksi.
3. Jalankan `npm install` dan `npm run build`; unggah kode beserta aset `public/build`.
4. Migrasikan database dengan `php artisan migrate --force` (atau impor cadangan yang telah disiapkan), lalu buat admin dengan kredensial produksi yang kuat.
5. Jalankan `php artisan storage:link`, pasang SSL, lalu di server jalankan:

   ```sh
   php artisan config:cache
   php artisan route:cache
   ```

6. Verifikasi HTTPS, form kontak, pengiriman email, sitemap di `/sitemap.xml`, dan robots di `/robots.txt`.

URL canonical, Open Graph, sitemap, dan JSON-LD mengikuti `APP_URL`. Pada environment selain production atau URL lokal, robots dan meta robots mencegah pengindeksan.

## Placeholder yang Harus Dilengkapi

- Harga paket: nilai awal `0` sengaja menampilkan “Hubungi kami untuk penawaran”.
- Logo klien dan thumbnail proyek: unggah berkas asli melalui panel admin; tidak ada logo/proyek rekaan yang disediakan.
- Testimoni: tambahkan hanya kutipan dan identitas yang telah disetujui klien.
- FAQ: sesuaikan teks bertanda `[SESUAIKAN...]` mengenai pembayaran, domain/hosting, dan masa dukungan.
- Kebijakan privasi dan syarat: lengkapi semua teks `[ISI NANTI: ...]`, termasuk tanggal pembaruan, retensi data, alamat usaha, persentase/ketentuan uang muka dan pengembalian, hak source code/lisensi, masa dukungan, pembatalan, serta domisili penyelesaian sengketa.
- Email: SMTP opsional untuk produksi; isi `MAIL_*` jika notifikasi harus dikirim melalui SMTP.

`database/schema.sql` berisi referensi skema dan data identitas/layanan awal. Seeder aplikasi juga mengisi empat klien dan data paket/FAQ sesuai spesifikasi.
