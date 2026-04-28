@extends('manuals.layout')
@section('content')
    <div class="cover">
        <img src="{{ public_path('template/perak.png') }}" alt="Logo APKM">
        <h1>Buku Panduan Pengguna</h1>
        <h2>Pembekal</h2>
        <p>Aplikasi Pengurusan KAFA Daerah Manjung (APKM)</p>
        <div class="badge">Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}</div>
    </div>

    <div class="section">
        <h3>1. Log Masuk Sistem</h3>
        <div class="step"><strong>Langkah 1:</strong> Pergi ke alamat sistem APKM menggunakan pelayar web.</div>
        <div class="step"><strong>Langkah 2:</strong> Masukkan <strong>Emel</strong> dan <strong>Kata Laluan</strong> yang diberikan oleh Pentadbir.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Masuk Sekarang"</strong>.</div>

        <h3>2. Semakan Pesanan Masuk</h3>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan</em> → <em>Pesanan Pembekal</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Senarai pesanan buku daripada semua sekolah akan dipaparkan.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik pada pesanan untuk melihat butiran: nama buku, kuantiti, dan sekolah.</div>

        <h3>3. Kemaskini Status Penghantaran</h3>
        <div class="step"><strong>Langkah 1:</strong> Klik <strong>"Proses"</strong> apabila pesanan mula diproses.</div>
        <div class="step"><strong>Langkah 2:</strong> Klik <strong>"Hantar"</strong> apabila buku telah dihantar ke sekolah.</div>
        <div class="note">Status: <em>Menunggu → Diproses → Dihantar → Lengkap</em>. Hanya Pentadbir boleh tandakan "Lengkap".</div>

        <h3>4. Had Akses Pembekal</h3>
        <table>
            <tr><th>Modul</th><th>Akses</th></tr>
            <tr><td>Pesanan Pembekal</td><td>✅ Baca &amp; Kemaskini Status</td></tr>
            <tr><td>Katalog Buku</td><td>✅ Baca Sahaja</td></tr>
            <tr><td>Rekod Murid</td><td>❌ Tiada Akses</td></tr>
            <tr><td>Laporan / Kewangan</td><td>❌ Tiada Akses</td></tr>
        </table>
    </div>

    <div class="footer">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) • Panduan Pembekal •
        Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}
    </div>
@endsection
