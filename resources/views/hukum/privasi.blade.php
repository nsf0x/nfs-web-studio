@extends('layouts.app')

@section('title', 'Kebijakan Privasi')
@section('meta_description', 'Kebijakan Privasi NFS Web Studio tentang pengumpulan, penggunaan, dan perlindungan data pribadi.')

@section('content')
<section class="gradient-navy -mt-16 py-16 pt-36 text-white md:-mt-20 md:pt-44">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <nav class="mb-5 flex items-center gap-2 text-sm text-gray-300">
            <a href="{{ route('home') }}" class="hover:text-gold">Beranda</a>
            <span>/</span>
            <span class="text-gold">Kebijakan Privasi</span>
        </nav>
        <h1 class="mb-3 text-3xl font-extrabold sm:text-4xl">Kebijakan Privasi</h1>
        <p class="text-gray-300">Terakhir diperbarui: [ISI NANTI: tanggal]</p>
    </div>
</section>

<section class="bg-white py-16">
    <article class="prose prose-lg mx-auto max-w-4xl px-4 text-gray-600 sm:px-6 lg:px-8">
        <p>NFS Web Studio ("kami") menghargai privasi Anda. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda saat menggunakan website ini, dengan mengacu pada peraturan perlindungan data pribadi yang berlaku di Indonesia.</p>

        <h2>1. Data yang Kami Kumpulkan</h2>
        <p>Kami mengumpulkan data yang Anda isi di formulir kontak: nama, email, nomor telepon, nama perusahaan, layanan atau paket yang diminati, kisaran budget, dan isi pesan. Data teknis dasar seperti alamat IP, jenis perangkat, dan browser juga dapat tercatat otomatis di log server.</p>

        <h2>2. Tujuan Penggunaan</h2>
        <p>Data digunakan untuk menanggapi pertanyaan dan permintaan penawaran, menghubungi Anda terkait layanan, menyusun penawaran, meningkatkan kualitas website dan keamanannya, serta memenuhi kewajiban hukum.</p>

        <h2>3. Pembagian Data</h2>
        <p>Kami tidak menjual atau menyewakan data pribadi Anda. Data hanya dapat diakses oleh pihak yang membantu operasional (misalnya penyedia hosting dan layanan email) sebatas yang diperlukan, atau jika diwajibkan oleh hukum.</p>

        <h2>4. Penyimpanan dan Keamanan</h2>
        <p>Data disimpan di server yang kami kelola dengan langkah pengamanan yang wajar. Data permintaan penawaran disimpan selama [ISI NANTI: jangka waktu, mis. 24 bulan] atau sampai Anda meminta penghapusan. Tidak ada sistem yang 100% aman, namun kami berupaya melindungi data Anda.</p>

        <h2>5. Cookie</h2>
        <p>Website ini menggunakan cookie yang diperlukan untuk fungsi dasar dan keamanan (misalnya sesi dan perlindungan formulir). [ISI NANTI: perbarui bagian ini jika memasang analitik atau iklan].</p>

        <h2>6. Hak Anda</h2>
        <p>Anda dapat meminta akses, koreksi, atau penghapusan data pribadi Anda, serta menarik persetujuan, dengan menghubungi kami di <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a>.</p>

        <h2>7. Tautan Pihak Ketiga</h2>
        <p>Website dapat memuat tautan ke layanan lain (misalnya WhatsApp dan Google Maps). Kebijakan privasi layanan tersebut berada di luar kendali kami.</p>

        <h2>8. Perubahan Kebijakan</h2>
        <p>Kebijakan dapat diperbarui sewaktu-waktu; perubahan berlaku sejak dipublikasikan di halaman ini.</p>

        <h2>9. Kontak</h2>
        <p>NFS Web Studio dapat dihubungi melalui email <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a> atau telepon <a href="tel:{{ preg_replace('/[^0-9+]/', '', $sitePhone) }}">{{ $sitePhone }}</a>. [ISI NANTI: alamat/domisili usaha jika ingin dicantumkan].</p>
    </article>
    <div class="mx-auto mt-10 flex max-w-4xl gap-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('syarat') }}" class="btn-secondary text-sm">Syarat & Ketentuan</a>
        <a href="{{ route('home') }}" class="btn-primary text-sm">Kembali ke Beranda</a>
    </div>
</section>
@endsection
