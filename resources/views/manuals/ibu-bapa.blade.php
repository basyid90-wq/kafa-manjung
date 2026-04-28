@extends('manuals.layout')
@section('content')
    <div class="cover">
        <img src="{{ public_path('template/perak.png') }}" alt="Logo APKM">
        <h1>Buku Panduan Pengguna</h1>
        <h2>Ibu Bapa / Penjaga</h2>
        <p>Aplikasi Pengurusan KAFA Daerah Manjung (APKM)</p>
        <div class="badge">Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}</div>
    </div>

    <div class="section">
        <h3>1. Cara Log Masuk</h3>
        <div class="step"><strong>Langkah 1:</strong> Pergi ke alamat sistem APKM menggunakan telefon atau komputer.</div>
        <div class="step"><strong>Langkah 2:</strong> Masukkan <strong>No. Kad Pengenalan</strong> anda (12 digit, tanpa sengkang).</div>
        <div class="step"><strong>Langkah 3:</strong> Masukkan <strong>Kata Laluan</strong> — kata laluan pertama anda adalah <em>No. Kad Pengenalan</em> anda sendiri.</div>
        <div class="step"><strong>Langkah 4:</strong> Klik <strong>"Masuk Sekarang"</strong>.</div>
        <div class="note">⚠️ Akaun anda hanya aktif setelah pihak sekolah mendaftarkan IC anda dalam profil anak.</div>

        <h3>2. Dashboard — Senarai Anak</h3>
        <p>Selepas log masuk, kad profil setiap anak yang dikaitkan dengan IC anda akan dipaparkan.</p>
        <div class="step">Klik <strong>"Lihat Profil Penuh"</strong> untuk maklumat terperinci anak.</div>

        <h3>3. Profil Penuh Anak (3 Tab)</h3>
        <h4>Tab 1 — Maklumat &amp; Kehadiran</h4>
        <p>Rekod kehadiran bulanan untuk tahun semasa. Setiap hari ditandakan dengan warna: <span style="color:green;"><strong>Hijau</strong></span> = Hadir, <span style="color:#b8860b;"><strong>Kuning</strong></span> = Lewat, <span style="color:red;"><strong>Merah</strong></span> = Tidak Hadir, <span style="color:grey;"><strong>Kelabu</strong></span> = Cuti Sakit. Ringkasan jumlah keseluruhan dipaparkan di bawah jadual.</p>
        <h4>Tab 2 — Prestasi Akademik</h4>
        <p>Markah dan gred bagi setiap mata pelajaran mengikut peperiksaan. Klik pada nama peperiksaan untuk melihat butiran markah setiap subjek.</p>
        <h4>Tab 3 — Sijil Pencapaian</h4>
        <p>Senarai sijil digital yang telah dikeluarkan untuk anak anda. Setiap sijil menunjukkan <strong>nama aktiviti atau peperiksaan</strong> yang berkaitan, tarikh keluaran, dan nombor rujukan unik.</p>
        <div class="step">Klik ikon <strong>pratonton</strong> pada mana-mana sijil untuk membuka paparan PDF sijil secara terus dalam skrin.</div>
        <div class="note">📌 Sijil yang dipaparkan di sini merangkumi sijil daripada <strong>aktiviti sekolah</strong> (contoh: Hari Sukan, Pertandingan) mahupun <strong>peperiksaan</strong> yang anak anda sertai. Kod QR pada setiap sijil boleh diimbas oleh sesiapa untuk mengesahkan kesahihannya tanpa perlu log masuk.</div>

        <h3>4. Rekod Disiplin</h3>
        <div class="step">Klik <em>Rekod Disiplin</em> di menu kiri untuk semak catatan tatatertib anak.</div>

        <h3>5. Hebahan Sekolah</h3>
        <div class="step">Klik <em>Hebahan</em> di menu kiri untuk baca pengumuman terkini daripada sekolah.</div>

        <h3>6. Pengesahan Sijil (QR)</h3>
        <p>Sijil digital dilengkapi kod QR. Sesiapa boleh mengimbas kod QR tersebut untuk mengesahkan kesahihan sijil tanpa perlu log masuk.</p>
    </div>

    <div class="footer">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) • Panduan Ibu Bapa / Penjaga •
        Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}
    </div>
@endsection
