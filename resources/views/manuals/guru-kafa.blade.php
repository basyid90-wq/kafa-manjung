@extends('manuals.layout')
@section('content')
    <div class="cover">
        <img src="{{ public_path('template/perak.png') }}" alt="Logo APKM">
        <h1>Buku Panduan Pengguna</h1>
        <h2>Guru KAFA</h2>
        <p>Aplikasi Pengurusan KAFA Daerah Manjung (APKM)</p>
        <div class="badge">Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}</div>
    </div>

    <div class="section">
        <h3>Log Masuk Sistem</h3>
        <div class="step"><strong>Langkah 1:</strong> Buka pelayar web dan pergi ke alamat sistem APKM.</div>
        <div class="step"><strong>Langkah 2:</strong> Masukkan <strong>Emel</strong> dan <strong>Kata Laluan</strong> anda.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik butang <strong>"Masuk Sekarang"</strong>.</div>
        <div class="note">Jika lupa kata laluan, hubungi Guru Besar atau Pentadbir sekolah anda untuk set semula.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 1: DATA ASAS</h3>

        <h4>1. Kelas</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kelas</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Senarai kelas yang ditetapkan kepada anda akan dipaparkan.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik pada nama kelas untuk melihat senarai murid dalam kelas tersebut.</div>
        <div class="note">⚠️ <strong>Penting:</strong> Nama kelas dalam sistem APKM <strong>MESTI sama persis</strong> dengan nama kelas dalam sistem <strong>SIMPENI</strong> (contoh: <em>Tahun 1 Ansar</em>, bukan <em>1 Ansar</em>). Hubungi Guru Besar jika terdapat perbezaan nama.</div>

        <h4>2. Murid</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Murid</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Senarai murid dalam kelas anda akan dipaparkan.</div>
        <div class="step"><strong>Langkah 3:</strong> Untuk tambah murid secara pukal, klik butang <strong>"Import dari SIMPENI"</strong>.</div>
        <div class="step"><strong>Langkah 4:</strong> Muat turun templat Excel, isi maklumat murid, kemudian muat naik semula fail tersebut.</div>
        <div class="note">📋 <strong>Fungsi Import SIMPENI:</strong> Sistem menerima fail Excel yang dieksport terus dari SIMPENI. Pastikan lajur <em>No. IC</em>, <em>Nama</em>, <em>Kelas</em>, <em>IC Bapa</em>, dan <em>IC Ibu</em> diisi lengkap. Akaun Ibu Bapa akan diwujudkan secara automatik.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 2: AKADEMIK & PELAJAR</h3>

        <h4>1. Jadual Waktu</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Jadual Waktu</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Jadual waktu mengajar anda mengikut kelas dan hari akan dipaparkan.</div>
        <div class="note">⚠️ <strong>Prasyarat:</strong> Fungsi ini hanya boleh digunakan setelah <strong>Guru Besar menetapkan waktu mengajar</strong> untuk setiap guru. Jika jadual belum muncul, sila maklumkan kepada Guru Besar.</div>

        <h4>2. Rekod RPH (Rancangan Pengajaran Harian)</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod RPH</em> → <strong>"Tambah RPH Baru"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi maklumat subjek, tarikh, topik, dan objektif pengajaran. Klik <strong>"Simpan"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> RPH akan dihantar kepada Guru Besar secara automatik untuk semakan dan kelulusan.</div>
        <div class="note">⚠️ <strong>Prasyarat:</strong> Jadual waktu <strong>MESTI</strong> ditetapkan oleh Guru Besar terlebih dahulu sebelum RPH boleh disimpan dengan kelas dan waktu yang betul.<br>
        Status RPH: <em>Menunggu → Diluluskan → Dikembalikan</em>. Semak maklum balas Guru Besar secara berkala.</div>

        <h4>3. Kehadiran</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Kehadiran</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih <strong>Tarikh</strong> dan <strong>Kelas</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik <strong>"Tandakan Semua Hadir"</strong> untuk kemudahan, kemudian ubah status murid yang berbeza.</div>
        <div class="step"><strong>Langkah 4:</strong> Status boleh dipilih: <em>Hadir / Lewat / Tidak Hadir / Cuti Sakit</em>.</div>
        <div class="step"><strong>Langkah 5:</strong> Klik <strong>"Simpan Kehadiran"</strong>.</div>
        <div class="note">Cuti berbilang hari: Gunakan ikon kalendar (🗓) pada baris murid untuk rekod Cuti Berjadual.</div>

        <h4>4. Masukkan Markah</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Masukkan Markah</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Pilih <strong>Peperiksaan</strong>, <strong>Kelas</strong>, dan <strong>Mata Pelajaran</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Masukkan markah bagi setiap murid dalam lajur yang disediakan.</div>
        <div class="step"><strong>Langkah 4:</strong> Klik <strong>"Kunci Markah"</strong> apabila semua markah selesai dimasukkan.</div>
        <div class="note">Markah yang sudah dikunci tidak boleh diubah tanpa kebenaran Guru Besar atau Pentadbir.</div>

        <h4>5. Disiplin Murid</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Disiplin Murid</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Klik <strong>"Tambah Rekod Disiplin"</strong>. Pilih murid, jenis kesalahan, dan tarikh.</div>
        <div class="step"><strong>Langkah 3:</strong> Isi keterangan kejadian dan tindakan yang diambil. Klik <strong>"Simpan"</strong>.</div>
        <div class="note">Rekod disiplin boleh dilihat oleh Ibu Bapa melalui portal mereka.</div>

        <h4>6. Aktiviti & Program</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Aktiviti & Program</em> → <strong>"Daftar Aktiviti Baru"</strong>.</div>
        <div class="step"><strong>Langkah 2:</strong> Isi nama aktiviti. Pada medan <strong>Peringkat Aktiviti</strong>, pilih <em>Peringkat Sekolah</em>. Isi tarikh, deskripsi ringkas, dan muat naik gambar dokumentasi (opsional). Klik <strong>"Simpan Aktiviti"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Klik ikon <strong>✓</strong> (kehadiran) pada kad aktiviti. Tandakan murid yang hadir menggunakan kotak semak. Gunakan <em>checkbox atas</em> untuk pilih semua murid dalam kelas sekaligus. Klik <strong>"Simpan Kehadiran"</strong>.</div>
        <div class="step"><strong>Langkah 4:</strong> Untuk jana sijil, klik ikon <strong>🏆</strong> (award) → pilih templat sijil → klik <strong>"Jana & Pratonton PDF"</strong>.</div>
        <div class="step"><strong>Langkah 5:</strong> Untuk sunting atau padam aktiviti, klik ikon pensel pada kad aktiviti berkenaan.</div>
        <div class="note">📌 <strong>Peringkat Aktiviti:</strong> Guru KAFA hanya boleh mendaftar aktiviti <em>Peringkat Sekolah</em> sahaja. Aktiviti yang anda daftar hanya kelihatan kepada warga sekolah anda. Anda boleh lihat aktiviti Peringkat Daerah dan Negeri dalam senarai yang sama (badge kuning/merah), tetapi tidak boleh mengubahnya.</div>

        <h4>7. Sijil Digital</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Sijil Digital</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Untuk jana sijil, pergi ke <em>Aktiviti & Program</em> → klik ikon award (🏆) pada aktiviti berkenaan.</div>
        <div class="step"><strong>Langkah 3:</strong> Pilih templat sijil, klik <strong>"Jana & Pratonton PDF"</strong>. Sijil dijana secara pukal untuk semua peserta.</div>
        <div class="note">Setiap sijil mempunyai kod QR unik untuk pengesahan kesahihan sijil secara dalam talian.</div>

        <h4>8. Rekod Pencapaian</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Rekod Pencapaian</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Klik <strong>"Tambah Rekod"</strong>, pilih kelas dan klik <strong>"Muat Murid"</strong>.</div>
        <div class="step"><strong>Langkah 3:</strong> Pilih Peperiksaan Pertengahan Tahun dan Akhir Tahun. Isi markah PHCI, Kelakuan, Kebersihan, dan Ulasan Guru bagi setiap murid.</div>
        <div class="step"><strong>Langkah 4:</strong> Klik <strong>"Simpan Rekod"</strong>. Kedudukan kelas dan darjah akan dikira secara automatik.</div>
        <div class="step"><strong>Langkah 5:</strong> Untuk cetak, klik ikon pencetak pada senarai rekod — borang Rekod Pencapaian rasmi akan dijana dalam format PDF.</div>
        <div class="note">⚠️ <strong>Prasyarat:</strong> Markah peperiksaan MESTI dimasukkan terlebih dahulu melalui modul <em>Masukkan Markah</em> sebelum jana rekod pencapaian.</div>

        <h3 style="margin-top:28px; color:#3a5bc7; border-bottom:2px solid #3a5bc7; padding-bottom:6px;">KATEGORI 3: LOGISTIK & KOMUNIKASI</h3>

        <h4>1. Hebahan</h4>
        <div class="step"><strong>Langkah 1:</strong> Klik <em>Pengurusan Pentadbiran</em> → <em>Hebahan</em>.</div>
        <div class="step"><strong>Langkah 2:</strong> Baca hebahan terkini daripada Guru Besar atau Pentadbir.</div>
        <div class="step"><strong>Langkah 3:</strong> Untuk hantar hebahan kepada warga sekolah, klik <strong>"Tambah Hebahan Baru"</strong>, isi tajuk dan isi kandungan, kemudian klik <strong>"Hantar"</strong>.</div>
    </div>

    <div class="footer">
        Aplikasi Pengurusan KAFA Daerah Manjung (APKM) • Panduan Guru KAFA •
        Versi 1.0 — {{ date('F Y', filemtime(__FILE__)) }}
    </div>
@endsection
