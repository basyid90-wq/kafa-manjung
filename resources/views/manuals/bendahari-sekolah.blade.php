@extends('manuals.layout')
@section('content')
    <div class="cover">
        <img src="{{ public_path('template/perak.png') }}" alt="Logo APKM">
        <h1>Buku Panduan Pengguna</h1>
        <h2>Bendahari Sekolah</h2>
        <p>Aplikasi Pengurusan KAFA Daerah Manjung (APKM)</p>
        <div class="badge">Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}</div>
    </div>

    <div class="section">
        <h3>1. Log Masuk Sistem</h3>
        <div class="step"><strong>Langkah 1:</strong> Pergi ke alamat sistem APKM menggunakan pelayar web.</div>
        <div class="step"><strong>Langkah 2:</strong> Masukkan <strong>Emel</strong> dan <strong>Kata Laluan</strong>. Klik <strong>"Masuk Sekarang"</strong>.</div>
        <div class="note">Jika lupa kata laluan, hubungi Pentadbir sistem untuk set semula.</div>

        <h3>2. Kemaskini Profil</h3>
        <div class="step"><strong>Langkah 1:</strong> Klik nama pengguna di penjuru kanan atas → <em>Lihat Profil</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Kemaskini nama, emel, atau kata laluan. Klik <strong>"Simpan"</strong>.</div>

        <div class="coming-soon">
            <h3>⏳ AKAN DATANG — Modul Pengurusan Kewangan</h3>
            <p>
                Modul Pengurusan Kewangan APKM sedang dalam <strong>fasa penyelarasan rasmi</strong>
                dengan prosedur perakaunan Jabatan Agama Islam Perak.<br><br>
                Buat masa ini, panduan hanya merangkumi cara log masuk dan kemaskini profil.<br><br>
                Panduan lengkap akan dikemaskini dan diedarkan semula apabila modul ini diaktifkan secara rasmi.
            </p>
        </div>

        <h3>3. Paparan Rekod Kewangan (Baca Sahaja)</h3>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kewangan</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak senarai rekod kutipan dan perbelanjaan.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon muat turun untuk eksport rekod ke Excel.</div>
    </div>

    <div class="footer">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) • Panduan Bendahari Sekolah •
        Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}
    </div>
@endsection
