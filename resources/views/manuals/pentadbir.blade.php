@extends('manuals.layout')
@section('content')
    <div class="cover">
        <img src="{{ public_path('template/perak.png') }}" alt="Logo APKM">
        <h1>Buku Panduan Pengguna</h1>
        <h2>Pentadbir Sistem</h2>
        <p>Aplikasi Pengurusan KAFA Daerah Manjung (APKM)</p>
        <div class="badge">Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}</div>
    </div>

    <div class="section">
        <h3>Log Masuk & Skop Akses</h3>
        <div class="step"><strong>Langkah 1:</strong> Log masuk menggunakan <strong>Emel</strong> dan <strong>Kata Laluan</strong> anda.</div>
        <p>Pentadbir mempunyai akses pentadbiran sistem yang luas merangkumi pengurusan data asas, pengguna, buku, dan laporan. Walau bagaimanapun, Pentadbir <strong>tidak boleh</strong> mendaftar, menyunting, mempadam, atau merekod kehadiran aktiviti — fungsi ini adalah hak Guru Besar, Guru KAFA, dan Penyelia KAFA.</p>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 1: DATA ASAS SISTEM</h3>

        <h4>1. Urus Daerah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Daerah</em> → <strong>"Tambah Daerah"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama daerah dan kod daerah. Klik <strong>"Simpan"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Untuk kemaskini, klik ikon pensel pada baris daerah berkenaan.</div>
        <div class="note">Daerah yang didaftarkan di sini akan digunakan sebagai skop data bagi Penyelia KAFA.</div>

        <h4>2. Urus Sekolah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Sekolah</em> → <strong>"Tambah Sekolah"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama sekolah, daerah, alamat, nombor telefon, dan logo sekolah (opsional). Klik <strong>"Simpan"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Untuk kemaskini maklumat sekolah sedia ada, klik ikon pensel.</div>
        <div class="note">Maklumat sekolah yang tepat penting kerana ia digunakan dalam cetakan sijil dan laporan rasmi.</div>

        <h4>3. Urus Pengguna</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Pengguna</em> → <strong>"Tambah Pengguna"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama, emel, peranan (Guru Besar / Penyelia KAFA / dll.), dan sekolah/daerah yang berkenaan. Set kata laluan awal.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Simpan"</strong>. Pengguna boleh log masuk menggunakan emel dan kata laluan yang ditetapkan.</div>
        <div class="step"><strong>Langkah 4:</strong> Untuk set semula kata laluan pengguna, klik ikon kunci pada baris pengguna berkenaan.</div>
        <div class="note">Akaun Ibu Bapa <strong>tidak perlu</strong> didaftarkan secara manual — ia diwujudkan secara automatik apabila IC Bapa/Ibu diisi dalam borang pendaftaran murid oleh guru.</div>

        <h4>4. Urus Mata Pelajaran</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Mata Pelajaran</em> → <strong>"Tambah Mata Pelajaran"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama subjek dan kod subjek. Klik <strong>"Simpan"</strong>.</div>
        <div class="note">Senarai mata pelajaran ini digunakan dalam modul Masukkan Markah dan Rekod Pencapaian di semua sekolah.</div>

        <h4>5. Urus Kelas</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kelas</em> → <strong>"Tambah Kelas"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih sekolah, isi nama kelas, dan tetapkan guru bertanggungjawab. Klik <strong>"Simpan"</strong>.</div>
        <div class="note">⚠️ Nama kelas <strong>MESTI sama persis</strong> dengan nama dalam sistem SIMPENI untuk membolehkan import data murid berfungsi.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 2: AKADEMIK & PELAJAR</h3>

        <h4>1. Kehadiran</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kehadiran</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Tapis mengikut sekolah, kelas, atau tarikh untuk semak atau eksport rekod kehadiran.</div>
        <div class="note">Pentadbir boleh melihat rekod kehadiran semua sekolah tetapi <strong>tidak boleh merekod atau mengubah</strong> kehadiran.</div>

        <h4>2. Rekod RPH</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod RPH</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak RPH yang dikemukakan oleh Guru Besar. Pentadbir boleh meluluskan atau mengembalikan RPH.</div>
        <div class="note">Pentadbir juga boleh semak KPI penyerahan RPH bagi semua sekolah dalam sistem.</div>

        <h4>3. Masukkan Markah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Masukkan Markah</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih peperiksaan, sekolah, kelas, dan mata pelajaran. Semak atau kemaskini markah.</div>
        <div class="step"><strong>Langkah 3:</strong> Pentadbir boleh membuka semula markah yang telah dikunci jika diperlukan pindaan.</div>

        <h4>4. Disiplin Murid</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Disiplin Murid</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak atau tambah rekod disiplin merentasi semua sekolah.</div>

        <h4>5. Aktiviti & Program (Baca Sahaja)</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Aktiviti & Program</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak senarai aktiviti dari semua sekolah dan semua peringkat (Sekolah / Daerah / Negeri).</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon <strong>🏆</strong> (award) untuk lihat senarai peserta dan sijil bagi mana-mana aktiviti.</div>
        <div class="note">⚠️ <strong>Had Akses:</strong> Pentadbir hanya boleh <strong>melihat</strong> aktiviti. Pendaftaran, penyuntingan, pemadaman, dan rekod kehadiran aktiviti adalah hak Guru Besar, Guru KAFA (peringkat sekolah), dan Penyelia KAFA (peringkat daerah).</div>

        <h4>6. Rekod Pencapaian</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod Pencapaian</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak rekod pencapaian murid merentasi semua sekolah mengikut kelas dan tahun.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 3: LOGISTIK & BUKU</h3>

        <h4>1. Katalog Buku</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Katalog Buku</em> → <strong>"Tambah Buku"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama buku, penulis, penerbit, dan harga. Muat naik imej kulit buku (opsional). Klik <strong>"Simpan"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Buku yang didaftarkan akan tersedia dalam senarai pilihan semasa sekolah membuat tempahan.</div>

        <h4>2. Tempahan Buku</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Tempahan Buku</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak semua pesanan dari sekolah-sekolah. Tapis mengikut status atau sekolah.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Lengkap"</strong> pada pesanan yang telah diterima oleh sekolah untuk tutup kes pesanan.</div>
        <div class="note">Status pesanan: <em>Menunggu → Diproses → Dihantar → Lengkap</em>. Hanya Pentadbir yang boleh tandakan status "Lengkap".</div>

        <h4>3. Hebahan</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Hebahan</em> → <strong>"Tambah Hebahan Baru"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi tajuk dan kandungan hebahan. Klik <strong>"Hantar"</strong>.</div>
        <div class="note">Hebahan daripada Pentadbir akan dipaparkan kepada semua pengguna dalam sistem.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 4: LAPORAN & KEWANGAN</h3>

        <h4>1. Laporan & Analisis</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Laporan & Analisis</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih jenis laporan: <em>Kehadiran</em>, <em>Prestasi Peperiksaan</em>, atau <em>Disiplin</em>. Tapis mengikut sekolah, bulan, atau semester.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Eksport PDF"</strong> atau <strong>"Eksport Excel"</strong> untuk cetak atau simpan laporan.</div>

        <h4>2. Kewangan</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kewangan</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Semak rekod kutipan dan perbelanjaan merentasi semua sekolah.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon muat turun untuk eksport rekod ke Excel.</div>
    </div>

    <div class="footer">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) • Panduan Pentadbir •
        Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}
    </div>
@endsection
