# CHANGELOG — KAFA Manjung

> **Arahan:** Fail ini dikemaskini AUTOMATIK oleh Claude setiap kali perubahan dibuat pada mana-mana fail projek.
> Selepas `git push` berjaya, tukar status kepada ✅ Sudah Push.

---

## 🖥️ Git Commands — Rujukan Pantas

### Localhost → VPS (Git Bash Windows)
```bash
# 1. Semak perubahan
git status

# 2. Stage semua perubahan
git add .

# 3. Commit dengan mesej
git commit -m "feat: [ringkasan perubahan]"

# 4. Push ke remote
git push origin main
```

### VPS — Pull perubahan terkini (Git Bash VPS / SSH)
```bash
# Masuk ke direktori projek
cd /var/www/kafa-manjung   # ubah jika path berbeza

# Pull perubahan
git pull origin main

# Jalankan perintah tambahan jika perlu
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📋 Log Perubahan

| # | Tarikh | Fail Diubah | Penerangan Perubahan | Status |
|---|--------|-------------|----------------------|--------|
| 1 | 2026-05-01 | `app/Models/ExamResult.php` | Tambah `is_locked` & `is_absent` dalam `$fillable` — fix isu simpan senyap | ✅ Sudah Push |
| 2 | 2026-05-01 | `app/Http/Controllers/ReportController.php` | Tambah filter `school_id` untuk Guru Besar dalam `exams()` — elak nampak data sekolah lain | ✅ Sudah Push |
| 3 | 2026-05-01 | `app/Http/Controllers/ReportController.php` | Fix `rphKpi()` — buang `abort(403)` untuk Guru Besar, tambah filter sekolah dia sahaja | ✅ Sudah Push |
| 4 | 2026-05-01 | `app/Http/Controllers/ExamController.php` | Tambah `authorizeSchoolAccess()` pada `edit/update/destroy` — elak akses peperiksaan sekolah lain | ✅ Sudah Push |
| 5 | 2026-05-01 | `app/Http/Controllers/ReportController.php` | Kemaskini `exams()` — tambah ranking GPS, jumlah daerah; tambah method `examsSchoolDetail()` baru | ✅ Sudah Push |
| 6 | 2026-05-01 | `routes/web.php` | Tambah route `reports/exams/{school}/detail` untuk halaman perincian subjek & kelas | ✅ Sudah Push |
| 7 | 2026-05-01 | `resources/views/reports/exams.blade.php` | Tambah kolum ranking, kad ringkasan daerah, baris jumlah daerah, tukar butang Tindakan ke perincian | ✅ Sudah Push |
| 8 | 2026-05-01 | `resources/views/reports/exams_detail.blade.php` | Halaman baru — perincian prestasi per subjek & per kelas untuk setiap sekolah | ✅ Sudah Push |
| 9 | 2026-05-01 | `CLAUDE.md` | Tambah peraturan auto-commit wajib (git status → commit → push → VPS commands) | ⏳ Belum Push |
| 10 | 2026-05-01 | `AGENTS.md` | Kemaskini CHANGELOG rule → tambah workflow git wajib untuk semua agent | ✅ Sudah Push |
| 11 | 2026-05-01 | `resources/views/components/head.blade.php` | Fix FOUC — tambah `body { visibility: hidden }` sebelum semua CSS loaded | ⏳ Belum Push |
| 12 | 2026-05-01 | `resources/views/layout/layout.blade.php` | Fix FOUC — tambah script reveal body selepas DOMContentLoaded | ✅ Sudah Push |
| 13 | 2026-05-01 | `app/Http/Controllers/StudentAchievementController.php` | Fix keselamatan: tambah authorizeRecordAccess() + semak school_id pada create/store/edit/show/generatePdf | ⏳ Belum Push |
| 14 | 2026-05-01 | `resources/views/achievements/create.blade.php` | Fix UX: auto-scroll ke senarai murid selepas pilih kelas + alert konfirmasi kelas dipilih | ⏳ Belum Push |
| 15 | 2026-05-01 | `resources/views/achievements/index_penyelia.blade.php` | Tambah: summary cards, filter tahun, ranking sekolah 🥇🥈🥉, highlight sekolah belum rekod, progress bar daerah | ✅ Sudah Push |
| 16 | 2026-05-02 | `database/migrations/2026_05_02_000001_add_amali_solat_to_student_achievement_records_table.php` | Migration baru — tambah kolum `amali_solat` (Lulus/Tidak Lulus) ke jadual rekod pencapaian | ✅ Sudah Push |
| 17 | 2026-05-02 | `app/Models/StudentAchievementRecord.php` | Tambah `amali_solat` ke `$fillable` | ✅ Sudah Push |
| 18 | 2026-05-02 | `app/Http/Controllers/StudentAchievementController.php` | Fix: status lock (Guru KAFA), status filter, bulk finalize, unlock, completion stats Guru Besar, amali_solat, exam marks preview | ✅ Sudah Push |
| 19 | 2026-05-02 | `routes/web.php` | Tambah route `achievements/bulk-finalize` dan `achievements/{achievement}/unlock` | ✅ Sudah Push |
| 20 | 2026-05-02 | `resources/views/achievements/index.blade.php` | Tambah: status filter, lock icon, unlock button, completion stats kelas (Guru Besar), bulk finalize per kelas | ✅ Sudah Push |
| 21 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Tambah: Amali Solat field, markah peperiksaan preview, lock warning rekod Final, disable input untuk rekod dikunci | ✅ Sudah Push |
| 22 | 2026-05-02 | `resources/views/achievements/show.blade.php` | Tambah: Amali Solat display, unlock button (Guru Besar), kemaskini button untuk rekod Draf | ✅ Sudah Push |
| 23 | 2026-05-02 | `app/Models/KafaClass.php` | Fix: tambah relationship `achievementRecords()` — fix BadMethodCallException pada halaman pencapaian Guru Besar | ⏳ Belum Push |
| 24 | 2026-05-02 | `resources/views/achievements/pdf.blade.php` | Tambah baris Amali Solat dalam jadual PDF sedia ada | ⏳ Belum Push |
| 25 | 2026-05-02 | `resources/views/achievements/pdf_bg.blade.php` | Baharu: PDF Cara A — overlay teks di atas PNG template rasmi borang pencapaian | ⏳ Belum Push |
| 26 | 2026-05-02 | `public/images/rekod-pencapaian-template.png` | Tambah PNG template borang rasmi sebagai background PDF | ⏳ Belum Push |
| 27 | 2026-05-02 | `app/Http/Controllers/StudentAchievementController.php` | Kemaskini generatePdf() — auto guna pdf_bg jika PNG template wujud (Cara A) | ⏳ Belum Push |
| 28 | 2026-05-02 | `app/Http/Controllers/ExamResultController.php` | Fix 1+2+5: tambah EXPECTED_SLOTS, slot_warning, ranking recalculate selepas save/lock, lindungi delete senyap | ⏳ Belum Push |
| 29 | 2026-05-02 | `resources/views/exams/results/index.blade.php` | Fix 1: icon 🔗⚠️❌ pada subjek dropdown, alert slot hilang, tunjuk term dalam label peperiksaan | ⏳ Belum Push |
| 30 | 2026-05-02 | `resources/views/exams/results/show.blade.php` | Fix 1: tambah alert amaran jika subjek tiada form_slot yang dikenali | ⏳ Belum Push |
| 31 | 2026-05-02 | `resources/views/exams/results/enter.blade.php` | Fix 1+5: tambah slot_warning alert + kolum Kosongkan (explicit delete checkbox) per murid | ⏳ Belum Push |
| 32 | 2026-05-02 | `app/Http/Controllers/StudentAchievementController.php` | Fix 4: buang whereIn term filter — semua peperiksaan boleh dipilih dalam Rekod Pencapaian | ⏳ Belum Push |
| 33 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Fix 3: badge kelengkapan markah per murid (X/9 subjek) + alert amaran jika markah belum lengkap | ⏳ Belum Push |
| 34 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Fix: buang filter term dalam dropdown PT/AT — tunjuk semua peperiksaan dengan label PT/AT/lain | ⏳ Belum Push |
| 35 | 2026-05-02 | `resources/views/exams/results/index.blade.php` | Tambah butang "Urus Peperiksaan" → `exams.index` di bahagian atas halaman Kemasukan Markah | ⏳ Belum Push |
| 36 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Tukar dropdown kelas dari `name` ke `display_name` — tunjuk "Tahun X — Nama" supaya kelas tidak kelihatan duplikasi | ⏳ Belum Push |
| 37 | 2026-05-02 | `resources/views/achievements/index.blade.php` | Tukar table stats & dropdown filter kelas guna `display_name` — tunjuk tahun bersama nama kelas | ⏳ Belum Push |
| 38 | 2026-05-02 | `routes/web.php` | Fix: tambah route public `POST announcements/{id}/increment-view` — sebelum ini tiada route, AJAX view count sentiasa 404 | ⏳ Belum Push |
| 39 | 2026-05-02 | `database/migrations/2026_05_02_000002_create_feedback_table.php` | Migration baru — jadual `feedback` (user_id, module, description, image_path, status, admin_reply) | ⏳ Belum Push |
| 40 | 2026-05-02 | `app/Models/Feedback.php` | Model baru — Feedback dengan constants MODULES/STATUSES, accessors status_label/status_class | ⏳ Belum Push |
| 41 | 2026-05-02 | `app/Http/Controllers/FeedbackController.php` | Controller baru — create/store (semua role), index/show/update (Super Admin), systemLog (baca laravel.log) | ⏳ Belum Push |
| 42 | 2026-05-02 | `routes/web.php` | Tambah routes feedback (create/store/index/show/update) dan admin/system-log | ⏳ Belum Push |
| 43 | 2026-05-02 | `resources/views/feedback/create.blade.php` | Halaman baharu — form laporkan masalah (modul, penerangan, tangkapan skrin) | ⏳ Belum Push |
| 44 | 2026-05-02 | `resources/views/feedback/index.blade.php` | Halaman baharu — senarai aduan untuk Super Admin (filter status/modul) | ⏳ Belum Push |
| 45 | 2026-05-02 | `resources/views/feedback/show.blade.php` | Halaman baharu — butiran aduan + kemaskini status/balasan | ⏳ Belum Push |
| 46 | 2026-05-02 | `resources/views/admin/system_log.blade.php` | Halaman baharu — Log Viewer (baca laravel.log, tapis ikut paras error/warning/info/all) | ⏳ Belum Push |
| 47 | 2026-05-02 | `resources/views/partials/sidebar.blade.php` | Tambah "Laporkan Masalah" (non-Super Admin, atas Panduan Pengguna) + "Aduan Masalah" & "Log Sistem" (Super Admin Pemantauan) | ⏳ Belum Push |
| 48 | 2026-05-02 | `app/Http/Controllers/DashboardController.php` | Pisahkan Super Admin dari Pentadbir — Super Admin kini guna stats sistem (sekolah, pengguna, murid, baharu) + panel aduan + health check | ⏳ Belum Push |
| 49 | 2026-05-02 | `resources/views/dashboard/superadmin.blade.php` | Halaman baharu — Dashboard Super Admin: 4 stat cards + panel aduan terkini + panel kesihatan sistem | ⏳ Belum Push |
| 50 | 2026-05-02 | `resources/views/dashboard/index.blade.php` | Pisahkan route paparan Super Admin ke `dashboard.superadmin`, Pentadbir tetap `dashboard.admin` | ⏳ Belum Push |
| 51 | 2026-05-02 | `app/Http/Controllers/UserController.php` | Revamp index() — tambah tab peranan + search nama/emel, kiraan badge per tab, filter role, paginate 15 | ⏳ Belum Push |
| 52 | 2026-05-02 | `resources/views/users/index.blade.php` | Revamp — tambah tab peranan (SA/Penyelia), search bar, emel dalam baris nama, empty state mesej | ⏳ Belum Push |
| 53 | 2026-05-02 | `app/Http/Controllers/StudentController.php` | Revamp index() — tambah filter daerah/sekolah/tahun/kelas/search, tahunCounts, $applyScope closure, buang kod lama bertindih | ⏳ Belum Push |
| 54 | 2026-05-02 | `resources/views/students/index.blade.php` | Revamp — tambah dropdown Daerah (SA), Sekolah (SA/Penyelia), Kelas, search bar, tab Tahun 1-6 dengan badge kiraan, kolum Sekolah untuk SA/Penyelia | ⏳ Belum Push |

---

> Format status: ⏳ Belum Push &nbsp;|&nbsp; ✅ Sudah Push
