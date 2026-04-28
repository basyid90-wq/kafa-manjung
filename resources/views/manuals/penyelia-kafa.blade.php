@extends('manuals.layout')
@section('content')
    <div class="cover">
        <img src="{{ public_path('template/perak.png') }}" alt="Logo APKM">
        <h1>Buku Panduan Pengguna</h1>
        <h2>Penyelia KAFA</h2>
        <p>Aplikasi Pengurusan KAFA Daerah Manjung (APKM)</p>
        <div class="badge">Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}</div>
    </div>

    <div class="section">
        <h3>Log Masuk & Skop Akses</h3>
        <div class="step"><strong>Langkah 1:</strong> Log masuk menggunakan <strong>Emel</strong> dan <strong>Kata Laluan</strong> anda.</div>
        <p>Penyelia KAFA mempunyai akses pemantauan ke atas <strong>semua sekolah dalam daerah</strong> yang ditetapkan. Data dihadkan kepada daerah anda sahaja secara automatik. Penyelia KAFA <strong>tidak boleh</strong> mengubah data milik sekolah (seperti cipta/edit aktiviti sekolah, rekod markah, atau rekod kehadiran sekolah) — peranan ini adalah pemantau dan penganjur aktiviti peringkat daerah.</p>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 1: PEMANTAUAN DAERAH</h3>

        <h4>1. Kehadiran Daerah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kehadiran</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Tapis mengikut <strong>sekolah</strong>, <strong>kelas</strong>, atau <strong>bulan</strong> untuk semak rekod kehadiran mana-mana sekolah dalam daerah.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Eksport PDF"</strong> atau <strong>"Eksport Excel"</strong> untuk cetak laporan.</div>
        <div class="note">Penyelia KAFA boleh <strong>melihat</strong> rekod kehadiran semua sekolah dalam daerah, tetapi <strong>tidak boleh mengubah</strong> rekod tersebut.</div>

        <h4>2. Rekod RPH & Kelulusan</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod RPH</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Senarai RPH yang dikemukakan oleh semua Guru Besar dalam daerah akan dipaparkan.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik pada RPH untuk baca kandungan penuh. Pilih <strong>"Lulus"</strong> atau <strong>"Kembalikan"</strong> beserta ulasan kepada Guru Besar.</div>
        <div class="note">⚠️ <strong>Penting:</strong> Hanya Penyelia KAFA yang boleh <strong>membatalkan (revert)</strong> kelulusan RPH yang telah diberikan. Ini membolehkan Guru Besar menghantar semula RPH yang perlu dipinda.</div>

        <h4>3. KPI RPH Daerah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod RPH</em> → tab <strong>"KPI Daerah"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak peratusan penyerahan dan kelulusan RPH bagi setiap sekolah dalam daerah.</div>
        <div class="step"><strong>Langkah 3:</strong> Gunakan data ini untuk tindakan susulan kepada sekolah yang pencapaiannya rendah.</div>

        <h4>4. Prestasi Peperiksaan Daerah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Laporan & Analisis</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih jenis laporan: <em>Prestasi Peperiksaan</em>. Tapis mengikut sekolah, peperiksaan, atau mata pelajaran.</div>
        <div class="step"><strong>Langkah 3:</strong> Analisis markah keseluruhan daerah. Eksport ke PDF atau Excel untuk pelaporan rasmi.</div>

        <h4>5. Semakan Murid Daerah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Murid</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Senarai semua murid dalam daerah dipaparkan. Gunakan penapis sekolah atau kelas untuk carian lebih spesifik.</div>
        <div class="note">Penyelia KAFA boleh <strong>melihat</strong> semua data murid dalam daerah tetapi <strong>tidak boleh menambah atau mengubah</strong> rekod murid.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 2: AKTIVITI & PROGRAM DAERAH</h3>

        <h4>1. Cipta Aktiviti Peringkat Daerah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Aktiviti & Program</em> → <strong>"Daftar Aktiviti Baru"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama aktiviti. Pada medan <strong>Peringkat Aktiviti</strong>, pilih <em>Peringkat Daerah</em>. Isi tarikh, deskripsi ringkas, dan muat naik gambar dokumentasi (opsional). Klik <strong>"Simpan Aktiviti"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon <strong>✓</strong> (kehadiran) pada kad aktiviti. Murid akan dipaparkan mengikut <strong>kumpulan sekolah</strong>. Gunakan <em>checkbox atas</em> untuk pilih semua murid dari satu sekolah sekaligus.</div>
        <div class="step"><strong>Langkah 4:</strong> Tandakan murid dari setiap sekolah yang menyertai aktiviti. Klik <strong>"Simpan Kehadiran"</strong>.</div>
        <div class="step"><strong>Langkah 5:</strong> Untuk jana sijil, klik ikon <strong>🏆</strong> (award) → pilih templat sijil peringkat daerah → klik <strong>"Jana & Pratonton PDF"</strong>.</div>
        <div class="note">📌 <strong>Skop Aktiviti Daerah:</strong> Aktiviti Peringkat Daerah yang anda cipta akan kelihatan kepada semua Guru Besar dan Guru KAFA dalam daerah, tetapi mereka <strong>tidak boleh mengubah atau memadamnya</strong>. Hanya Penyelia KAFA dan Super Admin yang boleh edit/padam aktiviti daerah.</div>

        <h4>2. Semak Aktiviti Sekolah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Aktiviti & Program</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Senarai aktiviti dari <strong>semua sekolah</strong> dalam daerah dipaparkan bersama badge peringkat (Hijau = Sekolah, Kuning = Daerah).</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon <strong>🏆</strong> (award) untuk lihat senarai peserta dan sijil bagi mana-mana aktiviti.</div>
        <div class="note">Penyelia KAFA boleh <strong>merekod kehadiran</strong> untuk aktiviti peringkat daerah miliknya sahaja. Untuk aktiviti sekolah, akses kehadiran adalah bagi pihak sekolah.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 3: SIJIL & TEMPLAT DAERAH</h3>

        <h4>1. Urus Templat Sijil Peringkat Daerah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Sijil Digital</em> → <strong>"Tambah Templat"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama templat. Pilih <strong>Peringkat: Daerah</strong>. Muat naik imej latar sijil dan tandatangan digital (opsional).</div>
        <div class="step"><strong>Langkah 3:</strong> Pilih gaya susun atur teks (tengah / bawah / kiri / kanan). Klik <strong>"Simpan"</strong>.</div>
        <div class="step"><strong>Langkah 4:</strong> Templat ini boleh dipilih semasa jana sijil pukal untuk aktiviti peringkat daerah.</div>
        <div class="note">Templat Peringkat Daerah yang dibuat oleh Penyelia KAFA <strong>boleh digunakan</strong> oleh semua sekolah dalam daerah semasa jana sijil aktiviti sekolah. Ini membolehkan penyeragaman reka bentuk sijil di peringkat daerah.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 4: LOGISTIK & KOMUNIKASI</h3>

        <h4>1. Pemantauan Tempahan Buku</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Tempahan Buku</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak status tempahan buku semua sekolah dalam daerah: <em>Menunggu → Diproses → Dihantar → Lengkap</em>.</div>
        <div class="step"><strong>Langkah 3:</strong> Gunakan penapis sekolah untuk fokus kepada satu sekolah.</div>
        <div class="note">Penyelia KAFA boleh memantau status pesanan tetapi <strong>tidak boleh menambah atau mengubah</strong> pesanan sekolah.</div>

        <h4>2. Katalog Buku</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Katalog Buku</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak senarai buku yang tersedia untuk sekolah-sekolah dalam daerah.</div>
        <div class="note">Penyelia KAFA mempunyai akses baca sahaja terhadap katalog buku.</div>

        <h4>3. Hebahan</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Hebahan</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Baca hebahan terkini. Untuk hantar hebahan kepada semua sekolah dalam daerah, klik <strong>"Tambah Hebahan Baru"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Isi tajuk dan kandungan, kemudian klik <strong>"Hantar"</strong>.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 5: KEWANGAN (BACA SAHAJA)</h3>

        <h4>1. Rekod Kewangan Sekolah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kewangan</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak rekod kutipan dan perbelanjaan bagi sekolah-sekolah dalam daerah.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon muat turun untuk eksport rekod ke Excel bagi tujuan semakan.</div>
        <div class="note">Penyelia KAFA mempunyai akses <strong>baca sahaja</strong> terhadap rekod kewangan. Penambahan rekod dilakukan oleh Bendahari Sekolah masing-masing.</div>
    </div>

    <div class="footer">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) • Panduan Penyelia KAFA •
        Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}
    </div>
@endsection
