@extends('manuals.layout')
@section('content')
    <div class="cover">
        <img src="{{ public_path('template/perak.png') }}" alt="Logo APKM">
        <h1>Buku Panduan Pengguna</h1>
        <h2>Guru Besar</h2>
        <p>Aplikasi Pengurusan KAFA Daerah Manjung (APKM)</p>
        <div class="badge">Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}</div>
    </div>

    <div class="section">
        <h3>Log Masuk & Skop Akses</h3>
        <div class="step"><strong>Langkah 1:</strong> Log masuk menggunakan <strong>Emel</strong> dan <strong>Kata Laluan</strong> anda.</div>
        <p>Guru Besar mempunyai akses penuh ke atas semua data sekolah yang ditetapkan. Semua data dihadkan kepada sekolah anda sahaja secara automatik.</p>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 1: DATA ASAS</h3>

        <h4>1. Pengguna</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Pengguna</em> → <strong>"Tambah Pengguna"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama, emel, peranan (Guru KAFA / Bendahari Sekolah), dan set kata laluan awal.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Simpan"</strong>. Pengguna baharu boleh log masuk menggunakan emel dan kata laluan yang ditetapkan.</div>
        <div class="note">Akaun Ibu Bapa <strong>tidak perlu</strong> didaftarkan secara manual — ia diwujudkan secara automatik apabila IC Bapa/Ibu diisi dalam borang pendaftaran murid.</div>

        <h4>2. Sekolah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Sekolah</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak dan kemaskini maklumat sekolah seperti alamat, nombor telefon, dan nama Pengetua jika perlu.</div>
        <div class="note">Maklumat sekolah yang tepat penting kerana ia digunakan dalam cetakan sijil dan laporan rasmi.</div>

        <h4>3. Kelas</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kelas</em> → <strong>"Tambah Kelas"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama kelas dan tetapkan guru yang bertanggungjawab.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Simpan"</strong>.</div>
        <div class="note">⚠️ <strong>Penting:</strong> Nama kelas dalam APKM <strong>MESTI sama persis</strong> dengan nama kelas dalam sistem <strong>SIMPENI</strong> (contoh: <em>Tahun 1 Ansar</em>). Ketidaksepadanan nama akan menyebabkan ralat semasa import data murid.</div>

        <h4>4. Murid</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Murid</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Untuk daftarkan murid secara individu, klik <strong>"Tambah Murid Baru"</strong> dan isi borang termasuk <em>IC Bapa</em> dan <em>IC Ibu</em>.</div>
        <div class="step"><strong>Langkah 3:</strong> Untuk daftarkan murid secara pukal, klik butang <strong>"Import dari SIMPENI"</strong>.</div>
        <div class="step"><strong>Langkah 4:</strong> Muat turun templat Excel, isi maklumat murid berdasarkan data SIMPENI, kemudian muat naik semula fail tersebut.</div>
        <div class="note">📋 <strong>Fungsi Import SIMPENI:</strong> Fail Excel yang dieksport dari SIMPENI boleh dimuat naik terus. Pastikan lajur <em>No. IC</em>, <em>Nama</em>, <em>Kelas</em>, <em>IC Bapa</em>, dan <em>IC Ibu</em> diisi lengkap. Akaun Ibu Bapa diwujudkan secara automatik — IC menjadi kata laluan pertama mereka.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 2: AKADEMIK & PELAJAR</h3>

        <h4>1. Jadual Waktu</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Jadual Waktu</em> → <strong>"Tambah Waktu Mengajar"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih <strong>Guru</strong>, <strong>Kelas</strong>, <strong>Mata Pelajaran</strong>, <strong>Hari</strong>, dan <strong>Waktu</strong>. Klik <strong>"Simpan"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Ulang untuk setiap guru dan kelas dalam sekolah anda.</div>
        <div class="note">🔴 <strong>WAJIB Dilakukan:</strong> Guru Besar <strong>MESTI</strong> menetapkan jadual waktu mengajar bagi setiap guru sebelum guru-guru tersebut boleh menggunakan modul <em>Jadual Waktu</em> dan <em>Rekod RPH</em>. Tanpa penetapan ini, fungsi-fungsi berkenaan tidak akan berfungsi dengan betul.</div>

        <h4>2. Rekod RPH (Rancangan Pengajaran Harian)</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod RPH</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak senarai RPH yang dikemukakan oleh Guru KAFA sekolah anda.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik pada RPH untuk baca kandungan penuh. Pilih <strong>"Lulus"</strong> atau <strong>"Kembalikan"</strong> beserta ulasan.</div>
        <div class="note">🔴 <strong>WAJIB Dilakukan:</strong> Jadual waktu mengajar <strong>MESTI</strong> ditetapkan terlebih dahulu agar Guru KAFA boleh memilih kelas dan waktu yang betul semasa menyediakan RPH.</div>

        <h4>3. Kehadiran</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kehadiran</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih kelas dan tarikh untuk semak rekod kehadiran yang diisi oleh Guru KAFA.</div>
        <div class="step"><strong>Langkah 3:</strong> Guru Besar juga boleh rekod kehadiran secara manual jika diperlukan.</div>

        <h4>4. Masukkan Markah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Masukkan Markah</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih Peperiksaan, Kelas, dan Mata Pelajaran. Masukkan atau semak markah murid.</div>
        <div class="step"><strong>Langkah 3:</strong> Guru Besar boleh membuka semula markah yang telah dikunci oleh Guru KAFA jika perlu pindaan.</div>

        <h4>5. Disiplin Murid</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Disiplin Murid</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak semua rekod disiplin murid sekolah. Guru Besar boleh tambah atau padam rekod.</div>
        <div class="note">Rekod disiplin boleh dilihat oleh Ibu Bapa melalui portal mereka.</div>

        <h4>6. Aktiviti & Program</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Aktiviti & Program</em> → <strong>"Daftar Aktiviti Baru"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama aktiviti, pilih <strong>Peringkat Aktiviti</strong> (<em>Peringkat Sekolah</em>), tarikh, deskripsi, dan gambar dokumentasi (opsional). Klik <strong>"Simpan Aktiviti"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon <strong>✓</strong> (kehadiran) pada kad aktiviti untuk tandakan murid yang menyertai. Murid akan dipaparkan mengikut kelas.</div>
        <div class="step"><strong>Langkah 4:</strong> Klik ikon <strong>🏆</strong> (award) pada kad aktiviti → pilih templat sijil → klik <strong>"Jana & Pratonton PDF"</strong> untuk jana sijil pukal semua peserta.</div>
        <div class="note">📌 <strong>Peringkat Aktiviti:</strong> Guru Besar hanya boleh mendaftar aktiviti <em>Peringkat Sekolah</em>. Aktiviti peringkat daerah dianjurkan oleh Penyelia KAFA. Setiap kad aktiviti memaparkan lencana warna: <span style="color:green;"><strong>Hijau</strong></span> = Sekolah, <span style="color:#b8860b;"><strong>Kuning</strong></span> = Daerah, <span style="color:red;"><strong>Merah</strong></span> = Negeri.</div>

        <h4>7. Pindah Murid</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Pindah Murid</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih murid yang hendak dipindahkan dan kelas destinasi baharu.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Proses Pindahan"</strong>. Rekod murid akan dikemaskini secara automatik.</div>

        <h4>8. Sijil Digital</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Sijil Digital</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Klik <strong>"Tambah Templat"</strong> — muat naik imej latar dan tandatangan digital Guru Besar.</div>
        <div class="step"><strong>Langkah 3:</strong> Templat yang dibuat boleh digunakan semasa penjanaan sijil melalui modul <em>Aktiviti & Program</em>.</div>
        <div class="note">Setiap sijil mempunyai kod QR unik untuk pengesahan kesahihan secara dalam talian tanpa perlu log masuk.</div>

        <h4>9. Rekod Pencapaian</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod Pencapaian</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak senarai rekod pencapaian murid mengikut kelas dan tahun.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon pencetak untuk jana borang Rekod Pencapaian rasmi dalam PDF bagi setiap murid.</div>
        <div class="note">Guru Besar juga boleh tambah rekod baru. Kedudukan kelas dan darjah dikira secara automatik oleh sistem.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 3: LOGISTIK & KOMUNIKASI</h3>

        <h4>1. Tempahan Buku</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Tempahan Buku</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih buku dari katalog dan masukkan kuantiti yang diperlukan.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Hantar Pesanan"</strong>. Pesanan akan diproses oleh Pembekal.</div>
        <div class="note">Status pesanan: <em>Menunggu → Diproses → Dihantar → Lengkap</em>. Pemantauan status boleh dilakukan dalam senarai yang sama.</div>

        <h4>2. Hebahan</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Hebahan</em> → <strong>"Tambah Hebahan Baru"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi tajuk dan kandungan hebahan. Pilih sasaran penerima jika perlu.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Hantar"</strong>. Hebahan akan dipaparkan kepada semua pengguna berkenaan.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 4: PENTADBIRAN & LAPORAN</h3>

        <h4>1. Laporan & Analisis</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Laporan & Analisis</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih jenis laporan: <em>Kehadiran</em>, <em>Prestasi Peperiksaan</em>, atau <em>Disiplin</em>.</div>
        <div class="step"><strong>Langkah 3:</strong> Tapis mengikut bulan atau semester. Klik <strong>"Eksport PDF"</strong> atau <strong>"Eksport Excel"</strong> untuk cetak.</div>

        <h4>2. Kewangan</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kewangan</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak senarai rekod kutipan dan perbelanjaan sekolah.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon muat turun untuk eksport rekod ke format PDF atau Excel.</div>
        <div class="note">Guru Besar mempunyai akses baca sahaja terhadap rekod kewangan. Penambahan rekod dilakukan oleh Bendahari Sekolah.</div>
    </div>

    <div class="footer">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) • Panduan Guru Besar •
        Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}
    </div>
@endsection
