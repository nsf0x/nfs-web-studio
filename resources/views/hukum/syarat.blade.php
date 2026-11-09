@extends('layouts.app')

@section('title', 'Syarat & Ketentuan')
@section('meta_description', 'Syarat dan Ketentuan penggunaan layanan NFS Web Studio.')

@section('content')
<section class="gradient-navy -mt-16 py-16 pt-36 text-white md:-mt-20 md:pt-44">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <nav class="mb-5 flex items-center gap-2 text-sm text-gray-300">
            <a href="{{ route('home') }}" class="hover:text-gold">Beranda</a>
            <span>/</span>
            <span class="text-gold">Syarat & Ketentuan</span>
        </nav>
        <h1 class="mb-3 text-3xl font-extrabold sm:text-4xl">Syarat & Ketentuan</h1>
        <p class="text-gray-300">Terakhir diperbarui: [ISI NANTI: tanggal]</p>
    </div>
</section>

<section class="bg-white py-16">
    <article class="prose prose-lg mx-auto max-w-4xl px-4 text-gray-600 sm:px-6 lg:px-8">
        <p>Dengan menggunakan website dan layanan NFS Web Studio ("kami", "penyedia"), Anda ("klien") menyetujui syarat berikut. Syarat ini berlaku umum; rincian proyek tertentu diatur dalam penawaran atau perjanjian tertulis yang disepakati kedua pihak, yang diutamakan jika berbeda.</p>

        <h2>1. Lingkup Layanan</h2>
        <p>Ruang lingkup, fitur, jumlah halaman, dan estimasi waktu ditetapkan dalam penawaran yang disetujui. Permintaan di luar lingkup dibahas dan dapat dikenakan biaya tambahan.</p>

        <h2>2. Proses Kerja</h2>
        <p>Proses kerja meliputi konsultasi, penawaran, persetujuan, pembayaran uang muka, desain, pengembangan dan revisi, serta peluncuran.</p>

        <h2>3. Pembayaran</h2>
        <p>Uang muka sebesar [ISI NANTI: persentase] dibayarkan sebelum pengerjaan dimulai, dan pelunasan dibayarkan sebelum website diluncurkan atau diserahkan. Metode dan rekening pembayaran tercantum di penawaran. Uang muka yang telah dibayarkan [ISI NANTI: ketentuan pengembalian].</p>

        <h2>4. Kewajiban Klien</h2>
        <p>Klien menyediakan materi (teks, logo, foto, data) tepat waktu dan menjamin bahwa materi tersebut milik klien atau telah berizin. Klien bertanggung jawab atas tuntutan pihak ketiga terkait materi yang diberikan.</p>

        <h2>5. Revisi</h2>
        <p>Jumlah revisi mengikuti paket. Revisi adalah perbaikan atas desain dan konten sesuai brief awal. Perubahan konsep besar atau fitur baru dihitung sebagai pekerjaan tambahan.</p>

        <h2>6. Jadwal</h2>
        <p>Estimasi waktu dihitung sejak uang muka diterima dan materi lengkap. Keterlambatan materi, umpan balik, atau pembayaran dari klien dapat menggeser jadwal.</p>

        <h2>7. Hak Kekayaan Intelektual</h2>
        <p>Setelah pelunasan, klien memperoleh hak menggunakan hasil akhir website. [ISI NANTI: ketentuan kepemilikan source code, komponen pihak ketiga/open source, dan lisensi]. Kami berhak menampilkan hasil pekerjaan di portofolio kecuali klien menyatakan keberatan secara tertulis.</p>

        <h2>8. Domain dan Hosting</h2>
        <p>Pengadaan domain dan hosting dapat dibantu; biaya dan masa berlaku dijelaskan di penawaran. Perpanjangan menjadi tanggung jawab klien kecuali disepakati lain.</p>

        <h2>9. Dukungan Setelah Peluncuran</h2>
        <p>Kami memberi dukungan selama [ISI NANTI: masa support] untuk perbaikan kendala teknis atas hasil pekerjaan kami. Perawatan rutin dan pengembangan lanjutan adalah layanan terpisah.</p>

        <h2>10. Pembatalan</h2>
        <p>Pembatalan oleh klien setelah pengerjaan dimulai [ISI NANTI: ketentuan biaya dan pengembalian dana].</p>

        <h2>11. Batas Tanggung Jawab</h2>
        <p>Kami berupaya menghasilkan layanan terbaik, namun tidak bertanggung jawab atas kerugian tidak langsung, gangguan layanan pihak ketiga (hosting, domain, payment gateway), atau penyalahgunaan website oleh pihak lain setelah penyerahan.</p>

        <h2>12. Kerahasiaan</h2>
        <p>Informasi bisnis yang klien bagikan kepada kami dijaga kerahasiaannya dan hanya digunakan untuk keperluan pekerjaan.</p>

        <h2>13. Hukum dan Penyelesaian Sengketa</h2>
        <p>Syarat ini tunduk pada hukum Republik Indonesia. Sengketa diselesaikan lebih dahulu melalui musyawarah; jika tidak tercapai, melalui [ISI NANTI: pengadilan/domisili].</p>

        <h2>14. Kontak</h2>
        <p>Hubungi NFS Web Studio melalui email <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a> atau telepon <a href="tel:{{ preg_replace('/[^0-9+]/', '', $sitePhone) }}">{{ $sitePhone }}</a>.</p>
    </article>
    <div class="mx-auto mt-10 flex max-w-4xl gap-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('privasi') }}" class="btn-secondary text-sm">Kebijakan Privasi</a>
        <a href="{{ route('home') }}" class="btn-primary text-sm">Kembali ke Beranda</a>
    </div>
</section>
@endsection
