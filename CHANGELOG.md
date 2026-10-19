# CHANGELOG — eKafa Online (dahulu KAFA Manjung)

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
| 9 | 2026-05-01 | `CLAUDE.md` | Tambah peraturan auto-commit wajib (git status → commit → push → VPS commands) | ✅ Sudah Push |
| 10 | 2026-05-01 | `AGENTS.md` | Kemaskini CHANGELOG rule → tambah workflow git wajib untuk semua agent | ✅ Sudah Push |
| 11 | 2026-05-01 | `resources/views/components/head.blade.php` | Fix FOUC — tambah `body { visibility: hidden }` sebelum semua CSS loaded | ✅ Sudah Push |
| 12 | 2026-05-01 | `resources/views/layout/layout.blade.php` | Fix FOUC — tambah script reveal body selepas DOMContentLoaded | ✅ Sudah Push |
| 13 | 2026-05-01 | `app/Http/Controllers/StudentAchievementController.php` | Fix keselamatan: tambah authorizeRecordAccess() + semak school_id pada create/store/edit/show/generatePdf | ✅ Sudah Push |
| 14 | 2026-05-01 | `resources/views/achievements/create.blade.php` | Fix UX: auto-scroll ke senarai murid selepas pilih kelas + alert konfirmasi kelas dipilih | ✅ Sudah Push |
| 15 | 2026-05-01 | `resources/views/achievements/index_penyelia.blade.php` | Tambah: summary cards, filter tahun, ranking sekolah 🥇🥈🥉, highlight sekolah belum rekod, progress bar daerah | ✅ Sudah Push |
| 16 | 2026-05-02 | `database/migrations/2026_05_02_000001_add_amali_solat_to_student_achievement_records_table.php` | Migration baru — tambah kolum `amali_solat` (Lulus/Tidak Lulus) ke jadual rekod pencapaian | ✅ Sudah Push |
| 17 | 2026-05-02 | `app/Models/StudentAchievementRecord.php` | Tambah `amali_solat` ke `$fillable` | ✅ Sudah Push |
| 18 | 2026-05-02 | `app/Http/Controllers/StudentAchievementController.php` | Fix: status lock (Guru KAFA), status filter, bulk finalize, unlock, completion stats Guru Besar, amali_solat, exam marks preview | ✅ Sudah Push |
| 19 | 2026-05-02 | `routes/web.php` | Tambah route `achievements/bulk-finalize` dan `achievements/{achievement}/unlock` | ✅ Sudah Push |
| 20 | 2026-05-02 | `resources/views/achievements/index.blade.php` | Tambah: status filter, lock icon, unlock button, completion stats kelas (Guru Besar), bulk finalize per kelas | ✅ Sudah Push |
| 21 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Tambah: Amali Solat field, markah peperiksaan preview, lock warning rekod Final, disable input untuk rekod dikunci | ✅ Sudah Push |
| 22 | 2026-05-02 | `resources/views/achievements/show.blade.php` | Tambah: Amali Solat display, unlock button (Guru Besar), kemaskini button untuk rekod Draf | ✅ Sudah Push |
| 23 | 2026-05-02 | `app/Models/KafaClass.php` | Fix: tambah relationship `achievementRecords()` — fix BadMethodCallException pada halaman pencapaian Guru Besar | ✅ Sudah Push |
| 24 | 2026-05-02 | `resources/views/achievements/pdf.blade.php` | Tambah baris Amali Solat dalam jadual PDF sedia ada | ✅ Sudah Push |
| 25 | 2026-05-02 | `resources/views/achievements/pdf_bg.blade.php` | Baharu: PDF Cara A — overlay teks di atas PNG template rasmi borang pencapaian | ✅ Sudah Push |
| 26 | 2026-05-02 | `public/images/rekod-pencapaian-template.png` | Tambah PNG template borang rasmi sebagai background PDF | ✅ Sudah Push |
| 27 | 2026-05-02 | `app/Http/Controllers/StudentAchievementController.php` | Kemaskini generatePdf() — auto guna pdf_bg jika PNG template wujud (Cara A) | ✅ Sudah Push |
| 28 | 2026-05-02 | `app/Http/Controllers/ExamResultController.php` | Fix 1+2+5: tambah EXPECTED_SLOTS, slot_warning, ranking recalculate selepas save/lock, lindungi delete senyap | ✅ Sudah Push |
| 29 | 2026-05-02 | `resources/views/exams/results/index.blade.php` | Fix 1: icon 🔗⚠️❌ pada subjek dropdown, alert slot hilang, tunjuk term dalam label peperiksaan | ✅ Sudah Push |
| 30 | 2026-05-02 | `resources/views/exams/results/show.blade.php` | Fix 1: tambah alert amaran jika subjek tiada form_slot yang dikenali | ✅ Sudah Push |
| 31 | 2026-05-02 | `resources/views/exams/results/enter.blade.php` | Fix 1+5: tambah slot_warning alert + kolum Kosongkan (explicit delete checkbox) per murid | ✅ Sudah Push |
| 32 | 2026-05-02 | `app/Http/Controllers/StudentAchievementController.php` | Fix 4: buang whereIn term filter — semua peperiksaan boleh dipilih dalam Rekod Pencapaian | ✅ Sudah Push |
| 33 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Fix 3: badge kelengkapan markah per murid (X/9 subjek) + alert amaran jika markah belum lengkap | ✅ Sudah Push |
| 34 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Fix: buang filter term dalam dropdown PT/AT — tunjuk semua peperiksaan dengan label PT/AT/lain | ✅ Sudah Push |
| 35 | 2026-05-02 | `resources/views/exams/results/index.blade.php` | Tambah butang "Urus Peperiksaan" → `exams.index` di bahagian atas halaman Kemasukan Markah | ✅ Sudah Push |
| 36 | 2026-05-02 | `resources/views/achievements/create.blade.php` | Tukar dropdown kelas dari `name` ke `display_name` — tunjuk "Tahun X — Nama" supaya kelas tidak kelihatan duplikasi | ✅ Sudah Push |
| 37 | 2026-05-02 | `resources/views/achievements/index.blade.php` | Tukar table stats & dropdown filter kelas guna `display_name` — tunjuk tahun bersama nama kelas | ✅ Sudah Push |
| 38 | 2026-05-02 | `routes/web.php` | Fix: tambah route public `POST announcements/{id}/increment-view` — sebelum ini tiada route, AJAX view count sentiasa 404 | ✅ Sudah Push |
| 39 | 2026-05-02 | `database/migrations/2026_05_02_000002_create_feedback_table.php` | Migration baru — jadual `feedback` (user_id, module, description, image_path, status, admin_reply) | ✅ Sudah Push |
| 40 | 2026-05-02 | `app/Models/Feedback.php` | Model baru — Feedback dengan constants MODULES/STATUSES, accessors status_label/status_class | ✅ Sudah Push |
| 41 | 2026-05-02 | `app/Http/Controllers/FeedbackController.php` | Controller baru — create/store (semua role), index/show/update (Super Admin), systemLog (baca laravel.log) | ✅ Sudah Push |
| 42 | 2026-05-02 | `routes/web.php` | Tambah routes feedback (create/store/index/show/update) dan admin/system-log | ✅ Sudah Push |
| 43 | 2026-05-02 | `resources/views/feedback/create.blade.php` | Halaman baharu — form laporkan masalah (modul, penerangan, tangkapan skrin) | ✅ Sudah Push |
| 44 | 2026-05-03 | `resources/views/attendances/index.blade.php` | Tukar modal "Buku Kedatangan" kepada Flowbite Modal with CRUD pattern — ganti custom modal | ✅ Sudah Push |
| 45 | 2026-05-02 | `resources/views/feedback/index.blade.php` | Halaman baharu — senarai aduan untuk Super Admin (filter status/modul) | ✅ Sudah Push |
| 46 | 2026-05-02 | `resources/views/feedback/show.blade.php` | Halaman baharu — butiran aduan + kemaskini status/balasan | ✅ Sudah Push |
| 47 | 2026-05-03 | `resources/views/feedback/create.blade.php` | Tukar textarea kepada Flowbite WYSIWYG Editor (bold, italic, underline, lists) | ✅ Sudah Push |
| 48 | 2026-05-03 | `resources/views/feedback/show.blade.php` | Update display penerangan — render HTML dari WYSIWYG editor | ✅ Sudah Push |
| 49 | 2026-05-03 | `resources/views/feedback/create.blade.php` | Tukar file input ke Flowbite File Input pattern (tangkapan skrin) | ✅ Sudah Push |
| 50 | 2026-05-03 | `resources/views/students/index.blade.php` | Tukar file input ke Flowbite File Input pattern (import Excel SIMPENI) | ✅ Sudah Push |
| 51 | 2026-05-03 | `resources/views/students/create.blade.php` | Tukar file input ke Flowbite File Input pattern (gambar pelajar) | ✅ Sudah Push |
| 52 | 2026-05-03 | `resources/views/students/edit.blade.php` | Tukar file input ke Flowbite File Input pattern (gambar pelajar) | ✅ Sudah Push |
| 53 | 2026-05-03 | `resources/views/activities/create.blade.php` | Tukar file input ke Flowbite File Input pattern (gambar dokumentasi) | ✅ Sudah Push |
| 54 | 2026-05-03 | `resources/views/activities/edit.blade.php` | Tukar file input ke Flowbite File Input pattern (gambar dokumentasi) | ✅ Sudah Push |
| 55 | 2026-05-03 | `resources/views/schools/create.blade.php` | Tukar file input ke Flowbite File Input pattern (logo sekolah) | ✅ Sudah Push |
| 56 | 2026-05-03 | `resources/views/schools/edit.blade.php` | Tukar file input ke Flowbite File Input pattern (logo sekolah) | ✅ Sudah Push |
| 57 | 2026-05-03 | `resources/views/certificates/templates/create.blade.php` | Tukar file input ke Flowbite File Input pattern (tandatangan + background) | ✅ Sudah Push |
| 55 | 2026-05-03 | `resources/views/schools/create.blade.php` | Tukar file input ke Flowbite File Input pattern (logo sekolah) | ✅ Sudah Push |
| 56 | 2026-05-03 | `resources/views/schools/edit.blade.php` | Tukar file input ke Flowbite File Input pattern (logo sekolah) | ✅ Sudah Push |
| 57 | 2026-05-03 | `resources/views/certificates/templates/create.blade.php` | Tukar file input ke Flowbite File Input pattern (tandatangan & background) | ✅ Sudah Push |
| 46 | 2026-05-02 | `resources/views/admin/system_log.blade.php` | Halaman baharu — Log Viewer (baca laravel.log, tapis ikut paras error/warning/info/all) | ✅ Sudah Push |
| 47 | 2026-05-02 | `resources/views/partials/sidebar.blade.php` | Tambah "Laporkan Masalah" (non-Super Admin, atas Panduan Pengguna) + "Aduan Masalah" & "Log Sistem" (Super Admin Pemantauan) | ✅ Sudah Push |
| 48 | 2026-05-02 | `app/Http/Controllers/DashboardController.php` | Pisahkan Super Admin dari Pentadbir — Super Admin kini guna stats sistem (sekolah, pengguna, murid, baharu) + panel aduan + health check | ✅ Sudah Push |
| 49 | 2026-05-02 | `resources/views/dashboard/superadmin.blade.php` | Halaman baharu — Dashboard Super Admin: 4 stat cards + panel aduan terkini + panel kesihatan sistem | ✅ Sudah Push |
| 50 | 2026-05-02 | `resources/views/dashboard/index.blade.php` | Pisahkan route paparan Super Admin ke `dashboard.superadmin`, Pentadbir tetap `dashboard.admin` | ✅ Sudah Push |
| 51 | 2026-05-02 | `app/Http/Controllers/UserController.php` | Revamp index() — tambah tab peranan + search nama/emel, kiraan badge per tab, filter role, paginate 15 | ✅ Sudah Push |
| 52 | 2026-05-02 | `resources/views/users/index.blade.php` | Revamp — tambah tab peranan (SA/Penyelia), search bar, emel dalam baris nama, empty state mesej | ✅ Sudah Push |
| 53 | 2026-05-02 | `app/Http/Controllers/StudentController.php` | Revamp index() — tambah filter daerah/sekolah/tahun/kelas/search, tahunCounts, $applyScope closure, buang kod lama bertindih | ✅ Sudah Push |
| 54 | 2026-05-02 | `resources/views/students/index.blade.php` | Revamp — tambah dropdown Daerah (SA), Sekolah (SA/Penyelia), Kelas, search bar, tab Tahun 1-6 dengan badge kiraan, kolum Sekolah untuk SA/Penyelia | ✅ Sudah Push |
| 55 | 2026-05-02 | `resources/views/dashboard/admin.blade.php` | Fix: buang odometer span — angka dashboard Pentadbir kini papar dengan betul | ✅ Sudah Push |
| 56 | 2026-05-02 | `resources/views/dashboard/penyelia.blade.php` | Fix: buang odometer span — angka dashboard Penyelia KAFA kini papar dengan betul | ✅ Sudah Push |
| 57 | 2026-05-02 | `resources/views/dashboard/gurubesar.blade.php` | Fix: buang odometer span — angka dashboard Guru Besar kini papar dengan betul | ✅ Sudah Push |
| 58 | 2026-05-02 | `resources/views/dashboard/guru.blade.php` | Fix: buang odometer span — angka dashboard Guru KAFA kini papar dengan betul | ✅ Sudah Push |
| 59 | 2026-05-02 | `resources/views/students/index.blade.php` | Fix UI: guna rbt-form-group untuk dropdown filter, guna changed.bs.select event (bootstrap-select) ganti onchange | ✅ Sudah Push |
| 60 | 2026-05-03 | `resources/views/activities/attendance.blade.php` | Migrate ke Flowbite UI — per-group select-all checkbox, Tailwind table | ✅ Sudah Push |
| 61 | 2026-05-03 | `resources/views/achievements/create.blade.php` | Migrate ke Flowbite UI — Tailwind radio pills ganti Bootstrap btn-group, per-student cards | ✅ Sudah Push |
| 62 | 2026-05-03 | `resources/views/achievements/show.blade.php` | Migrate ke Flowbite UI — maklumat murid, markah table, penilaian lain | ✅ Sudah Push |
| 63 | 2026-05-03 | `resources/views/announcements/create-homepage.blade.php` | Migrate ke Flowbite UI — Quill editor, label select, datetime-local | ✅ Sudah Push |
| 64 | 2026-05-03 | `resources/views/announcements/edit-homepage.blade.php` | Migrate ke Flowbite UI — sama create + nilai sedia ada, PUT method | ✅ Sudah Push |
| 65 | 2026-05-03 | `resources/views/rph_approvals/history.blade.php` | Migrate ke Flowbite UI — search, status badges, openPdfBlob, revert form | ✅ Sudah Push |
| 66 | 2026-05-03 | `resources/views/feedback/create.blade.php` | Migrate ke Flowbite UI — module select, image upload dengan JS preview | ✅ Sudah Push |
| 67 | 2026-05-03 | `resources/views/feedback/show.blade.php` | Migrate ke Flowbite UI — info grid, status PATCH form dengan admin_reply | ✅ Sudah Push |
| 68 | 2026-05-03 | `resources/views/students/import_summary.blade.php` | Migrate ke Flowbite UI — 3 stat cards, jadual keputusan import | ✅ Sudah Push |
| 69 | 2026-05-03 | `resources/views/certificates/templates/create.blade.php` | Migrate ke Flowbite UI — JS toggle sekolah/tandatangan | ✅ Sudah Push |
| 70 | 2026-05-03 | `resources/views/timetable/create.blade.php` | Migrate ke Flowbite UI — grid 2-kolum untuk semua select | ✅ Sudah Push |
| 71 | 2026-05-03 | `resources/views/timetable/edit.blade.php` | Migrate ke Flowbite UI — nilai $timetable, PUT method | ✅ Sudah Push |
| 72 | 2026-05-03 | `resources/views/book_orders/create.blade.php` | Migrate ke Flowbite UI — katalog buku + addToCart() via fetch() | ✅ Sudah Push |
| 73 | 2026-05-03 | `resources/views/book_orders/cart.blade.php` | Migrate ke Flowbite UI — subtotal JS, clear cart, submit | ✅ Sudah Push |
| 74 | 2026-05-03 | `resources/views/book_orders/show.blade.php` | Migrate ke Flowbite UI — info order, items table, status actions, print CSS | ✅ Sudah Push |
| 75 | 2026-05-03 | `resources/views/book_orders/edit.blade.php` | Migrate ke Flowbite UI — edit draft, inline qty listener, row highlight | ✅ Sudah Push |
| 76 | 2026-05-03 | `resources/views/book_orders/supplier_summary.blade.php` | Migrate ke Flowbite UI — filter bulan/tahun, openPdfBlob, grandTotal | ✅ Sudah Push |
| 77 | 2026-05-03 | `resources/views/reports/attendance.blade.php` | Migrate ke Flowbite UI — filter, jadual sekolah, 3 stat cards | ✅ Sudah Push |
| 78 | 2026-05-03 | `resources/views/reports/exams.blade.php` | Migrate ke Flowbite UI — filter exam, ranking table, progress bars | ✅ Sudah Push |
| 79 | 2026-05-03 | `resources/views/reports/exams_detail.blade.php` | Migrate ke Flowbite UI — per-subjek/kelas tables, helper PHP statusBadge() | ✅ Sudah Push |
| 80 | 2026-05-03 | `resources/views/reports/rph_kpi.blade.php` | Migrate ke Flowbite UI — custom Tailwind modal #modalGuru, JS toggle toggle | ✅ Sudah Push |
| 81 | 2026-05-03 | `resources/views/reports/show.blade.php` | Migrate ke Flowbite UI — 3 stat cards, exam results, disciplinary table | ✅ Sudah Push |
| 82 | 2026-05-03 | `resources/views/parent/results/show.blade.php` | Migrate ke Flowbite UI — senarai peperiksaan untuk ibu bapa | ✅ Sudah Push |
| 83 | 2026-05-03 | `resources/views/parent/results/detail.blade.php` | Migrate ke Flowbite UI — slip keputusan, grade legend, print CSS | ✅ Sudah Push |
| 84 | 2026-05-03 | `resources/views/parents/dashboard.blade.php` | Migrate ke Flowbite UI — grid kad anak, Lateef font, avatar, status badge | ✅ Sudah Push |
| 85 | 2026-05-03 | `resources/views/parents/student_profile.blade.php` | Migrate ke Flowbite UI — switchTab() JS, panel info/exam/cert | ✅ Sudah Push |
| 86 | 2026-05-03 | `resources/views/exams/create.blade.php` | Migrate ke Flowbite UI — borang 3 medan: nama, tahun, penggal | ✅ Sudah Push |
| 87 | 2026-05-03 | `resources/views/disciplinary/create.blade.php` | Migrate ke Flowbite UI — borang 4 medan rekod disiplin | ✅ Sudah Push |
| 88 | 2026-05-03 | `resources/views/student_transfers/create.blade.php` | Migrate ke Flowbite UI — dual-mode form, jQuery → vanilla fetch() AJAX | ✅ Sudah Push |
| 89 | 2026-05-03 | `resources/views/auth/login.blade.php` | Migrate ke Flowbite UI — 2-kolum login + hebahan, custom tabs/modal, tanpa Bootstrap | ✅ Sudah Push |
| 90 | 2026-05-03 | `resources/views/layout-fb/auth.blade.php` | Cipta layout awam (tanpa sidebar) untuk halaman login | ✅ Sudah Push |
| 91 | 2026-05-03 | `resources/views/dashboard/index.blade.php` | Migrate ke Flowbite UI — delegate ke fb/ partials | ✅ Sudah Push |
| 92 | 2026-05-03 | `resources/views/exams/results/enter.blade.php` | Migrate ke Flowbite UI — jadual markah, TH/kosongkan checkbox, sticky footer | ✅ Sudah Push |
| 93 | 2026-05-03 | `resources/views/exams/results/show.blade.php` | Migrate ke Flowbite UI — paparan markah baca-sahaja, butang kunci Guru Besar | ✅ Sudah Push |
| 94 | 2026-05-03 | `resources/views/vendor/pagination/flowbite.blade.php` | Cipta custom pagination view Flowbite/Tailwind — nombor halaman, chevron SVG, papar rekod | ✅ Sudah Push |
| 95 | 2026-05-03 | `resources/views/vendor/pagination/flowbite-simple.blade.php` | Cipta simple pagination view (Sebelumnya/Seterusnya) tanpa nombor halaman | ✅ Sudah Push |
| 96 | 2026-05-03 | `app/Providers/AppServiceProvider.php` | Tukar pagination global ke Flowbite — ganti useBootstrapFive() dengan defaultView/defaultSimpleView | ✅ Sudah Push |
| 97 | 2026-05-03 | `CLAUDE.md` | Tulis semula CLAUDE.md — kemaskini untuk era Flowbite/Tailwind, buang Bootstrap, tambah panduan komponen Tailwind | ✅ Sudah Push |
| 98 | 2026-05-03 | `resources/views/layout-fb/layout.blade.php` | Tambah SweetAlert2, handler delete-form, PDF viewer (PDF.js), `openPdfBlob()`, `renderPdfBase64()`, `closePdfViewer()` | ✅ Sudah Push |
| 99 | 2026-05-03 | `resources/views/layout-fb/layout.blade.php` | Tambah global Flowbite Datepicker init — auto-tukar semua `input[type=date]` ke Flowbite calendar picker | ✅ Sudah Push |
| 100 | 2026-05-03 | `resources/views/auth/login.blade.php` | Fix hero gradient — tukar Tailwind gradient classes ke inline style supaya VPS nampak tanpa rebuild | ✅ Sudah Push |
| 101 | 2026-05-03 | `resources/views/activities/create.blade.php` | Kemaskini file input ke Flowbite File Input dengan helper text format/saiz | ✅ Sudah Push |
| 102 | 2026-05-03 | `resources/views/activities/edit.blade.php` | Kemaskini file input ke Flowbite File Input dengan helper text | ✅ Sudah Push |
| 103 | 2026-05-03 | `resources/views/feedback/create.blade.php` | Kemaskini file input ke Flowbite File Input dengan helper text | ✅ Sudah Push |
| 104 | 2026-05-03 | `resources/views/students/create.blade.php` | Kemaskini file input ke Flowbite File Input dengan helper text | ✅ Sudah Push |
| 105 | 2026-05-03 | `resources/views/students/edit.blade.php` | Kemaskini file input ke Flowbite File Input dengan helper text | ✅ Sudah Push |
| 106 | 2026-05-03 | `resources/views/certificates/templates/create.blade.php` | Kemaskini 2 file input (tandatangan + latar) ke Flowbite File Input dengan helper text | ✅ Sudah Push |
| 107 | 2026-05-03 | `routes/web.php` | Tambah route awam `/waktu-solat` — proxy JAKIM API untuk widget waktu solat (tanpa CORS) | ✅ Sudah Push |
| 108 | 2026-05-03 | `resources/views/components/prayer-times-widget.blade.php` | Cipta Blade component widget Waktu Solat — flip clock, dropdown negeri/zon JAKIM, waktu solat grid aktif | ✅ Sudah Push |
| 109 | 2026-05-03 | `resources/views/auth/login.blade.php` | Reka bentuk semula — hero heading-mark, login card Flowbite, horizontal card hebahan, prayer widget | ✅ Sudah Push |
| 110 | 2026-05-03 | `resources/views/dashboard/index.blade.php` | Tambah `<x-prayer-times-widget />` di bawah semua dashboard role | ✅ Sudah Push |
| 111 | 2026-05-03 | `resources/views/auth/login.blade.php` | Reka bentuk semula hero — tajuk lebih besar (`clamp` VPS-safe), semua inline style, dekorasi bulatan, teks dua baris dengan warna aksen biru cerah | ✅ Sudah Push |
| 112 | 2026-05-03 | `resources/views/auth/login.blade.php` | Fix: buang margin-top overlap, tab login visible, inline CSS grid, buang waktu solat | ✅ Sudah Push |
| 113 | 2026-05-03 | `resources/views/auth/login.blade.php` | Susun semula: login atas centred, pengumuman full-width bawah, buang widget solat | ✅ Sudah Push |
| 114 | 2026-05-03 | `resources/views/auth/login.blade.php` | Tab Flowbite icons, Lupa Kata Laluan → WhatsApp 0194920559, semua inline style | ✅ Sudah Push |
| 115 | 2026-05-03 | `resources/views/auth/login.blade.php` | 6 kemaskini: logo asal, teks pengumuman besar, badge "Sistem KAFA", tab full-width, Ada masalah → WA, footer v1.0 | ✅ Sudah Push |
| 116 | 2026-05-03 | `CLAUDE.md` | Tambah Codex sebagai AI agent kedua, peraturan UI wajib Flowbite docs, VPS-safe CSS rule, kemaskini Do Not list | ✅ Sudah Push |
| 117 | 2026-05-03 | `resources/views/layout-fb/layout.blade.php` | Tambah bell notification + profile avatar dropdown ke navbar — guna Flowbite Dropdown + Alpine.js | ✅ Sudah Push |
| 118 | 2026-05-03 | `resources/views/layout-fb/layout.blade.php` | Tambah fungsi global `updateFilename()` — dikongsi semua file input di seluruh aplikasi | ✅ Sudah Push |
| 119 | 2026-05-03 | `resources/views/students/index.blade.php` | Kemaskini file input Import SIMPENI ke Flowbite File Input inline style (VPS-safe) | ✅ Sudah Push |
| 120 | 2026-05-03 | `resources/views/activities/create.blade.php` | Kemaskini file input ke Flowbite File Input inline style (VPS-safe) | ✅ Sudah Push |
| 121 | 2026-05-03 | `resources/views/schools/create.blade.php` | Kemaskini file input logo ke Flowbite File Input inline style (VPS-safe) | ✅ Sudah Push |
| 122 | 2026-05-03 | `resources/views/schools/edit.blade.php` | Kemaskini file input logo ke Flowbite File Input inline style (VPS-safe) | ✅ Sudah Push |
| 123 | 2026-05-03 | `resources/views/attendances/index.blade.php` | Tukar semula modal Buku Kedatangan ke inline style; ganti `type="month"` dengan dua select Bulan+Tahun (VPS-safe) | ✅ Sudah Push |
| 124 | 2026-05-03 | `resources/views/layout-fb/layout.blade.php` | Fix datepicker calendar z-index (z-9999) + tukar wrapper ke inline style supaya tidak bertindih dengan elemen lain | ✅ Sudah Push |
| 125 | 2026-05-03 | `resources/views/layout-fb/layout.blade.php` | Buang Flowbite datepicker global (overlay bertindih) — guna native type="date" browser semula, tambah ikon kalendar sahaja | ✅ Sudah Push |
| 126 | 2026-05-03 | `resources/views/achievements/pdf.blade.php` | Fix kedudukan gred markah — guna bidi-override span supaya "86 (B)" tidak terbalik jadi ")B( 86" dalam RTL mPDF | ✅ Sudah Push |
| 127 | 2026-05-10 | `resources/views/components/phone-input.blade.php` | Komponen baru: Flowbite Phone Input dengan prefiks Malaysia (+60) tetap, dark mode support via CSS | ✅ Sudah Push |
| 128 | 2026-05-10 | `resources/views/students/create.blade.php` | Tukar input father_phone dan mother_phone ke komponen `<x-phone-input>` | ✅ Sudah Push |
| 129 | 2026-05-10 | `resources/views/students/edit.blade.php` | Tukar input father_phone dan mother_phone ke komponen `<x-phone-input>` | ✅ Sudah Push |
| 130 | 2026-05-10 | `resources/views/schools/create.blade.php` | Tukar input no_telefon ke komponen `<x-phone-input>` | ✅ Sudah Push |
| 131 | 2026-05-10 | `resources/views/schools/edit.blade.php` | Tukar input no_telefon ke komponen `<x-phone-input>` | ✅ Sudah Push |
| 132 | 2026-05-10 | `resources/views/students/qr_cards.blade.php` | Reka semula paparan skrin ke gaya Flowbite "Share profile with QR" (gradient header, avatar bulat, kad bersih); cetak kekal layout kompak A4 2 kolum | ✅ Sudah Push |
| 133 | 2026-05-10 | `resources/views/auth/login.blade.php` | Tukar layout login page dari 1 kolum ke 2 kolum (login kiri, papan makluman kanan); mobile kekal atas-bawah | ✅ Sudah Push |
| 134 | 2026-05-10 | `database/migrations/2026_05_10_150001_create_chatbot_providers_table.php` | Migration baru: chatbot_providers + chatbot_settings table, seed 4 provider (DeepSeek, OpenAI, Gemini, Groq) | ✅ Sudah Push |
| 135 | 2026-05-10 | `app/Models/ChatbotProvider.php` | Model baru: ChatbotProvider dengan helper icon, is_safe, decrypted_key | ✅ Sudah Push |
| 136 | 2026-05-10 | `app/Models/ChatbotSetting.php` | Model baru: ChatbotSetting (global toggle data_access_enabled) | ✅ Sudah Push |
| 137 | 2026-05-10 | `app/Http/Controllers/ChatbotController.php` | Controller baru: proxy AI API, role-aware system prompt, PDPA toggle logic | ✅ Sudah Push |
| 138 | 2026-05-10 | `resources/views/super-admin/chatbot-settings.blade.php` | View baru: panel settings chatbot Super Admin (provider cards, API key, toggle data) | ✅ Sudah Push |
| 139 | 2026-05-10 | `resources/views/components/chatbot-widget.blade.php` | Komponen baru: floating chat bubble widget dengan conversation history | ✅ Sudah Push |
| 140 | 2026-05-10 | `routes/web.php` | Tambah routes chatbot (message, settings, activate, toggle-data) | ✅ Sudah Push |
| 141 | 2026-05-10 | `resources/views/layout-fb/layout.blade.php` | Inject <x-chatbot-widget /> sebelum </body> untuk semua authenticated pages | ✅ Sudah Push |
| 142 | 2026-05-10 | `database/migrations/2026_05_10_160001_add_bot_profile_to_chatbot_settings_table.php` | Tambah kolum bot_name dan bot_avatar ke chatbot_settings | ✅ Sudah Push |
| 143 | 2026-05-10 | `app/Models/ChatbotSetting.php` | Tambah bot_name & bot_avatar ke fillable | ✅ Sudah Push |
| 144 | 2026-05-10 | `app/Http/Controllers/ChatbotController.php` | Tambah updateBotProfile() untuk upload gambar & nama chatbot | ✅ Sudah Push |
| 145 | 2026-05-10 | `routes/web.php` | Tambah route chatbot.bot-profile + chatbot.settings dalam sidebar | ✅ Sudah Push |
| 146 | 2026-05-10 | `resources/views/super-admin/chatbot-settings.blade.php` | Tambah section Profil Chatbot (nama + avatar upload dengan preview) | ✅ Sudah Push |
| 147 | 2026-05-10 | `resources/views/components/chatbot-widget.blade.php` | Widget papar nama & avatar dinamik dari DB; bot message bubble guna avatar sama | ✅ Sudah Push |
| 148 | 2026-05-10 | `resources/views/layout-fb/layout.blade.php` | Tambah menu "Tetapan Chatbot AI" dalam sidebar Super Admin | ✅ Sudah Push |
| 149 | 2026-05-10 | `resources/views/components/chatbot-widget.blade.php` | Textarea auto-grow oninput — kotak input kembang mengikut panjang teks, kecil semula selepas hantar | ✅ Sudah Push |
| 150 | 2026-05-10 | `routes/web.php` | Tambah route POST chatbot.provider.deactivate untuk matikan provider aktif | ✅ Sudah Push |
| 151 | 2026-05-10 | `app/Http/Controllers/ChatbotController.php` | Tambah method deactivateProvider() — matikan provider tanpa perlu aktifkan yang lain | ✅ Sudah Push |
| 152 | 2026-05-10 | `resources/views/super-admin/chatbot-settings.blade.php` | Tukar "Sedang Aktif" static label kepada butang "Matikan" merah dengan confirm dialog | ✅ Sudah Push |
| 153 | 2026-06-25 | `resources/views/auth/login.blade.php` | Redesign penuh login page jadi landing page moden: Hero + Features grid + Login form + Footer. Guna Tailwind CSS + Alpine.js sahaja, buang semua inline style & jQuery | ✅ Sudah Push |
| 154 | 2026-10-18 | `database/migrations/2026_10_18_000001_saas_remove_district_and_book_modules.php` | Migrasi pivot SaaS: buang jadual districts/books/book_orders, kolum district_id, role lama; MyKid unik per sekolah; pindah murid guna to_school_name | ✅ Sudah Push |
| 155 | 2026-10-18 | `database/migrations/2026_04_18_060456_update_book_orders_statuses.php` | Langkau ALTER MySQL-only bila bukan MySQL (ujian SQLite boleh jalan semula) | ✅ Sudah Push |
| 156 | 2026-10-18 | `app/Models/Concerns/BelongsToSchool.php` | BARU: global scope tenant — Guru Besar/Guru KAFA hanya nampak data sekolah sendiri, school_id auto-isi | ✅ Sudah Push |
| 157 | 2026-10-18 | `app/Models/*.php (13 model)` | Pasang trait BelongsToSchool; buang relasi district(); User tambah isSuperAdmin() & canAccessSchool() | ✅ Sudah Push |
| 158 | 2026-10-18 | `app/Http/Controllers/Controller.php` | Tambah helper authorizeSchool() untuk semakan tenant | ✅ Sudah Push |
| 159 | 2026-10-18 | `app/Http/Controllers/{Book,BookOrder,District,Role}Controller.php` | Dipadam — modul jabatan (buku, daerah, peranan) dibuang | ✅ Sudah Push |
| 160 | 2026-10-18 | `app/Http/Controllers/UserController.php` | Buang role lama; FIX IDOR — Guru Besar hanya urus Guru KAFA sekolah sendiri | ✅ Sudah Push |
| 161 | 2026-10-18 | `app/Http/Controllers/SchoolController.php` | Buang daerah; FIX IDOR — Guru Besar hanya lihat/edit sekolah sendiri | ✅ Sudah Push |
| 162 | 2026-10-18 | `app/Http/Controllers/KafaClassController.php` | Buang Penyelia; FIX get-teachers/get-classes bocor data sekolah lain; guru mesti dari sekolah sama | ✅ Sudah Push |
| 163 | 2026-10-18 | `app/Http/Controllers/StudentController.php` | Buang daerah; kelas & MyKid diskop ikut sekolah; authorizeSchool pada semua tindakan | ✅ Sudah Push |
| 164 | 2026-10-18 | `app/Http/Controllers/TimetableController.php` | FIX IDOR edit/update/destroy/printPdf; kelas/subjek/guru/slot mesti dari sekolah sama | ✅ Sudah Push |
| 165 | 2026-10-18 | `app/Http/Controllers/AnnouncementController.php` | Buang daerah; Guru Besar hanya boleh hebah kepada sekolah sendiri (sebelum ini boleh hantar ke semua pengguna) | ✅ Sudah Push |
| 166 | 2026-10-18 | `app/Http/Controllers/ActivityController.php` | Aktiviti sentiasa milik sekolah; kehadiran aktiviti hanya murid sekolah sendiri (sebelum ini peringkat negeri senarai SEMUA murid) | ✅ Sudah Push |
| 167 | 2026-10-18 | `app/Http/Controllers/StudentTransferController.php` | Tukar jadi "pindah keluar" — murid diarkib, destinasi teks bebas; tiada lagi pemindahan data ke tenant lain | ✅ Sudah Push |
| 168 | 2026-10-18 | `app/Http/Controllers/{Financial,CertificateTemplate,Subject,Report,RphApproval,RphRecord,RphPdf,StudentAchievement,StudentImport,Dashboard,Manual,Chatbot}Controller.php` | Buang cabang Pentadbir/Penyelia/Pembekal/Bendahari; tambah semakan tenant; RPH Guru Besar auto-lulus; Kewangan diurus Guru Besar | ✅ Sudah Push |
| 169 | 2026-10-18 | `routes/web.php` | Buang laluan buku/daerah/peranan; senarai role tinggal Super Admin, Guru Besar, Guru KAFA, Ibu Bapa | ✅ Sudah Push |
| 170 | 2026-10-18 | `resources/views/** (≈40 fail)` | Buang medan/penapis daerah & blok role lama; padam view buku, daerah, peranan, dashboard lama, manual role lama; grid Pengurusan disusun semula | ✅ Sudah Push |
| 171 | 2026-10-18 | `resources/views/layout-fb/{layout,auth}.blade.php` | Jenama baharu: eKafa Online (buang logo & teks Perak/APKM) | ✅ Sudah Push |
| 172 | 2026-10-18 | `database/seeders/*` | Seeder SaaS: 4 role; Super Admin dari .env (buang kata laluan hard-coded); DemoSeeder 2 sekolah (local sahaja); padam CleanUpSeeder & SchoolSeeder | ✅ Sudah Push |
| 173 | 2026-10-18 | `tests/Feature/TenantIsolationTest.php` | BARU: 9 ujian isolasi tenant | ✅ Sudah Push |
| 174 | 2026-10-18 | `CLAUDE.md, AGENTS.md, docs/SECURITY.md, docs/SYSTEM_FLOW.md, .env.example` | Dokumen dikemas kini untuk SaaS: role baharu, peraturan tenant, push ke branch saas (bukan main) | ✅ Sudah Push |
| 175 | 2026-10-18 | `database/migrations/2026_10_18_000002_add_subscription_plan_to_schools.php` | BARU: kolum type, plan, plan_expires_at, owner_id pada schools (tenant = ruang kerja berlangganan) | ✅ Sudah Push |
| 176 | 2026-10-18 | `config/plans.php` | BARU: definisi pakej Percuma/Personal/Sekolah, had (3 kelas × 40 murid untuk Percuma) dan peta modul → pakej | ✅ Sudah Push |
| 177 | 2026-10-18 | `app/Models/School.php` | Logik pakej: effectivePlan() dengan tempoh tangguh, allows(), limit(), canAddClass(), studentPlacesLeft(), scopeWithModule() | ✅ Sudah Push |
| 178 | 2026-10-18 | `app/Models/User.php` | Tambah canUse(), hasPortalChildren(), roleLabel() ("Guru (Personal)") | ✅ Sudah Push |
| 179 | 2026-10-18 | `app/Http/Middleware/EnsurePlanAllows.php, bootstrap/app.php` | BARU: middleware plan:<modul> — modul berkunci dihala ke halaman Langganan | ✅ Sudah Push |
| 180 | 2026-10-18 | `routes/web.php` | 58 laluan dikunci ikut pakej; tambah laluan /langganan | ✅ Sudah Push |
| 181 | 2026-10-18 | `app/Http/Controllers/SubscriptionController.php, resources/views/subscription/index.blade.php` | BARU: halaman Langganan — pakej semasa, penggunaan kelas/murid, perbandingan pakej, butang naik taraf (WhatsApp sementara Bayarcash belum siap) | ✅ Sudah Push |
| 182 | 2026-10-18 | `resources/views/pengurusan/index.blade.php` | Jubin modul berkunci kekal dipapar (lencana pakej + mangga) dan menghala ke Langganan | ✅ Sudah Push |
| 183 | 2026-10-18 | `resources/views/layout-fb/layout.blade.php, resources/views/dashboard/index-fb.blade.php` | Menu Langganan + lencana pakej; label role "Guru (Personal)"; widget Chatbot hanya untuk pakej yang ada modul AI | ✅ Sudah Push |
| 184 | 2026-10-18 | `app/Http/Controllers/SchoolController.php, resources/views/schools/{edit,index}.blade.php` | Super Admin boleh aktifkan pakej (jenis, pakej, tarikh tamat, pemilik); senarai sekolah papar lencana pakej | ✅ Sudah Push |
| 185 | 2026-10-18 | `app/Http/Controllers/{KafaClass,Student,StudentImport}Controller.php, app/Imports/StudentsImport.php` | Had pakej: bilangan kelas & murid sekelas; FIX import kini dikunci ikut school_id + MyKid (tidak lagi sentuh murid sekolah lain); penapis umur murid mudah alih (tiada TIMESTAMPDIFF) | ✅ Sudah Push |
| 186 | 2026-10-18 | `app/Http/Controllers/{Parent,ParentResult,Disciplinary}Controller.php` | Portal Ibu Bapa hanya untuk anak di sekolah berpakej Sekolah; akaun ibu bapa hanya dicipta jika pakej membenarkan | ✅ Sudah Push |
| 187 | 2026-10-18 | `database/seeders/DemoSeeder.php` | Demo 3 tenant: Sekolah berbayar, Sekolah Percuma, Guru Personal | ✅ Sudah Push |
| 188 | 2026-10-18 | `tests/Feature/PlanGatingTest.php, tests/Feature/TenantIsolationTest.php` | BARU: 11 ujian pakej & had; ujian tenant dikemas kini | ✅ Sudah Push |
| 189 | 2026-10-18 | `CLAUDE.md` | Peraturan wajib pakej (plan gating) untuk modul baharu | ✅ Sudah Push |
| 190 | 2026-10-18 | `config/plans.php` | Pakej Personal kini tanpa had kelas & murid (keputusan pemilik) | ✅ Sudah Push |
| 191 | 2026-10-18 | `app/Http/Controllers/Auth/RegisteredUserController.php, routes/auth.php, resources/views/auth/register.blade.php` | BARU: daftar sendiri di /daftar — pilih Sekolah atau Guru (Personal), cipta ruang kerja Percuma, honeypot + had kadar | ✅ Sudah Push |
| 192 | 2026-10-18 | `app/Models/User.php, routes/web.php, app/Providers/AppServiceProvider.php` | Pengesahan e-mel diwajibkan (MustVerifyEmail + middleware verified); e-mel pengesahan & set semula kata laluan dalam BM | ✅ Sudah Push |
| 193 | 2026-10-18 | `resources/views/auth/{verify-email,forgot-password,reset-password,confirm-password}.blade.php, resources/views/layout-fb/auth-card.blade.php` | Halaman auth ditulis semula dalam BM dengan layout Flowbite (ganti Breeze) | ✅ Sudah Push |
| 194 | 2026-10-18 | `resources/views/legal/{terms,privacy}.blade.php` | BARU: draf Terma Perkhidmatan & Notis Privasi (PDPA) — perlu semakan pemilik | ✅ Sudah Push |
| 195 | 2026-10-18 | `lang/ms/{auth,passwords,validation}.php, config/app.php, .env.example` | BARU: terjemahan BM; locale lalai ms | ✅ Sudah Push |
| 196 | 2026-10-18 | `app/Http/Controllers/DashboardController.php, resources/views/dashboard/fb/gurubesar.blade.php` | Senarai semak onboarding (profil, kelas, murid, slot masa, jemput guru); FIX senarai RPH menunggu (status pending); sembunyi kad guru untuk Personal | ✅ Sudah Push |
| 197 | 2026-10-18 | `database/migrations/2026_10_18_000003_create_invitations_table.php, app/Models/Invitation.php, app/Notifications/TeacherInvitation.php` | BARU: jemputan guru melalui e-mel (token disimpan sebagai hash, sah 7 hari) | ✅ Sudah Push |
| 198 | 2026-10-18 | `app/Http/Controllers/InvitationController.php, resources/views/invitations/*` | BARU: hantar/batal jemputan (pakej Sekolah) dan terima jemputan — akaun baharu atau gabung akaun sedia ada | ✅ Sudah Push |
| 199 | 2026-10-18 | `app/Services/WorkspaceMerger.php` | BARU: gabung ruang kerja Personal ke sekolah (semua data ikut guru; disekat jika MyKid bertindih) | ✅ Sudah Push |
| 200 | 2026-10-18 | `app/Http/Controllers/UserController.php, resources/views/users/index.blade.php` | Butang & modal Jemput Guru, senarai jemputan menunggu; pengguna dicipta admin terus disahkan | ✅ Sudah Push |
| 201 | 2026-10-18 | `database/migrations/2026_10_18_000004_make_school_code_nullable.php` | Kod sekolah tidak wajib (akaun daftar sendiri) | ✅ Sudah Push |
| 202 | 2026-10-18 | `resources/views/auth/login.blade.php` | Butang "Mula Sekarang" ke /daftar, pautan "Daftar percuma", Lupa Kata Laluan melalui e-mel | ✅ Sudah Push |
| 203 | 2026-10-18 | `tests/Feature/Auth/*, tests/Feature/{InvitationTest,ExampleTest,ProfileTest}.php` | BARU: 7 ujian pendaftaran + 8 ujian jemputan/gabung; ujian lama dibetulkan (6 kegagalan lama selesai, 2 dilangkau kerana padam akaun sendiri dimatikan) | ✅ Sudah Push |
| 204 | 2026-10-18 | `CLAUDE.md` | Peraturan daftar sendiri, pengesahan e-mel, jemputan dan BM | ✅ Sudah Push |
| 205 | 2026-10-18 | `config/plans.php, config/services.php, .env.example` | Harga pakej (Personal RM19, Sekolah RM49 sebulan) dan konfigurasi Bayarcash (sandbox/production, PAT, secret key, portal key) | ✅ Sudah Push |
| 206 | 2026-10-18 | `database/migrations/2026_10_18_000005_create_payments_table.php, app/Models/Payment.php` | BARU: rekod pembayaran; markPaid() aktifkan/lanjutkan pakej secara idempotent | ✅ Sudah Push |
| 207 | 2026-10-18 | `app/Services/Bayarcash.php` | BARU: klien Bayarcash v3 (payment intent + checksum HMAC-SHA256 + pengesahan callback/return) tanpa pakej tambahan | ✅ Sudah Push |
| 208 | 2026-10-18 | `app/Http/Controllers/BillingController.php, routes/web.php, bootstrap/app.php` | BARU: checkout /langganan/bayar, return URL, webhook /webhook/bayarcash (dikecualikan CSRF, disahkan checksum, semak jumlah) | ✅ Sudah Push |
| 209 | 2026-10-18 | `app/Http/Controllers/SubscriptionController.php, resources/views/subscription/index.blade.php` | Halaman Langganan: harga, butang Naik Taraf / Lanjutkan 1 Bulan, sejarah pembayaran | ✅ Sudah Push |
| 210 | 2026-10-18 | `app/Notifications/PlanExpiringNotification.php, routes/console.php` | BARU: arahan plans:remind (harian 09:00) — peringatan 7 & 1 hari sebelum pakej tamat | ✅ Sudah Push |
| 211 | 2026-10-18 | `tests/Feature/BillingTest.php` | BARU: 11 ujian pembayaran (checksum, callback palsu, jumlah salah, idempotent, pembaharuan, peringatan) | ✅ Sudah Push |
| 212 | 2026-10-18 | `CLAUDE.md, docs/SECURITY.md` | Peraturan pembayaran dan keselamatan kunci Bayarcash | ✅ Sudah Push |
| 213 | 2026-10-19 | `resources/views/auth/login.blade.php` | Laman utama baharu (reka bentuk Claude Design): 13 seksyen — hero dengan mock dashboard, modul, lawatan produk (5 tab), harga RM0/RM19/RM49, keselamatan, soalan lazim, log masuk, CTA; animasi & skrol; hebahan platform sebagai kad makluman; FIX graf kehadiran mingguan (bar tinggi 0) | ✅ Sudah Push |
| 214 | 2026-10-19 | `CLAUDE.md` | Nota: laman utama ialah halaman kendiri dan wajib npm run build semasa deploy | ✅ Sudah Push |
| 215 | 2026-10-19 | `database/seeders/DatabaseSeeder.php` | Buang panggilan DemoSeeder — seed asas sahaja (deploy bersih) | ✅ Sudah Push |
| 216 | 2026-10-19 | `database/seeders/DemoSeeder.php` | Dipadam — data demo tidak lagi digunakan | ✅ Sudah Push |
| 217 | 2026-10-19 | `resources/views/demo/index.blade.php` | Demo interaktif awam (dari draf Claude Design) — Vite ganti CDN, pautan daftar & font guna helper Laravel | ✅ Sudah Push |
| 218 | 2026-10-19 | `routes/web.php` | Route awam `GET /demo` (name: demo) | ✅ Sudah Push |
| 219 | 2026-10-19 | `resources/views/auth/login.blade.php` | Pautan "Cuba Demo" di navbar, menu mudah alih, hero dan CTA akhir | ✅ Sudah Push |
| 220 | 2026-10-19 | `tests/Feature/DemoPageTest.php` | Test: tetamu & pengguna log masuk boleh buka /demo, homepage memaut ke demo | ✅ Sudah Push |
| 221 | 2026-10-19 | `resources/css/app.css` | Kelas standard `ek-*` (butang, borang, kad, jadual, badge, menu sisi) ikut reka bentuk demo | ✅ Sudah Push |
| 222 | 2026-10-19 | `tailwind.config.js` | Font Inter; nota dark mode dihentikan | ✅ Sudah Push |
| 223 | 2026-10-19 | `resources/views/layout-fb/layout.blade.php` | Rangka baharu ikut demo: sidebar dengan logo & kad pelan, header sticky; buang dark mode | ✅ Sudah Push |
| 224 | 2026-10-19 | `resources/views/layout-fb/auth.blade.php` | Font Inter, buang kelas dark | ✅ Sudah Push |
| 225 | 2026-10-19 | `app/Http/Controllers/DashboardController.php` | Data dashboard: kehadiran hari ini, 7 hari, purata markah ikut subjek, hebahan (skop sekolah/kelas) | ✅ Sudah Push |
| 226 | 2026-10-19 | `resources/views/dashboard/index-fb.blade.php` | Pengepala dashboard baharu + butang Tanda Kehadiran | ✅ Sudah Push |
| 227 | 2026-10-19 | `resources/views/dashboard/fb/gurubesar.blade.php` | Dashboard Guru Besar ikut gaya demo | ✅ Sudah Push |
| 228 | 2026-10-19 | `resources/views/dashboard/fb/guru.blade.php` | Dashboard Guru KAFA ikut gaya demo (data kelas sendiri) | ✅ Sudah Push |
| 229 | 2026-10-19 | `resources/views/dashboard/fb/superadmin.blade.php` | Dashboard Super Admin guna kelas `ek-*` | ✅ Sudah Push |
| 230 | 2026-10-19 | `resources/views/dashboard/fb/_stat.blade.php` | Komponen kad statistik (baharu) | ✅ Sudah Push |
| 231 | 2026-10-19 | `resources/views/dashboard/fb/_insights.blade.php` | Graf kehadiran, purata markah, hebahan, tindakan pantas (baharu) | ✅ Sudah Push |
| 232 | 2026-10-19 | `tests/Feature/DashboardTest.php` | Test dashboard: kehadiran skop sekolah/kelas, purata markah, paparan kosong, Super Admin | ✅ Sudah Push |
| 233 | 2026-10-19 | `CLAUDE.md` | Peraturan UI: guna kelas `ek-*`, dark mode dihentikan, font Inter | ✅ Sudah Push |
| 234 | 2026-10-19 | `resources/views/manuals/guru-besar.blade.php`, `guru-kafa.blade.php` | Bahagian Dashboard dalam manual | ✅ Sudah Push |
| 235 | 2026-10-19 | `app/Http/Controllers/StudentController.php` | Guru KAFA: senarai, kiraan Tahun, lihat/edit/padam, padam pukal & kad QR hanya untuk murid kelas sendiri; kelas wajib dari kelas sendiri | ✅ Sudah Push |
| 236 | 2026-10-19 | `app/Models/Student.php`, `app/Models/User.php`, `app/Http/Controllers/Controller.php` | Skop `Student::visibleTo()`, `User::isClassScoped()` / `canAccessStudent()`, guard `authorizeStudent()` | ✅ Sudah Push |
| 237 | 2026-10-19 | `resources/views/students/index.blade.php` | Sembunyi pilihan "Tiada Kelas" untuk Guru KAFA | ✅ Sudah Push |
| 238 | 2026-10-19 | `tests/Feature/GuruKafaStudentScopeTest.php` | Test skop murid Guru KAFA ikut kelas (baharu) | ✅ Sudah Push |
| 239 | 2026-10-19 | `resources/views/manuals/guru-kafa.blade.php` | Nota: Guru KAFA hanya urus murid kelas sendiri | ✅ Sudah Push |
| 240 | 2026-10-19 | `app/Support/SidebarMenu.php` | Menu sisi modul ikut demo (Modul Asas/Personal/Sekolah, Tetapan, Pemantauan) — tapis ikut middleware role:, kunci ikut plan: (baharu) | ✅ Sudah Push |
| 241 | 2026-10-19 | `resources/views/layout-fb/layout.blade.php` | Guna SidebarMenu dengan lencana kunci; tajuk header/tab ikut menu aktif bila view tiada title | ✅ Sudah Push |
| 242 | 2026-10-19 | `tests/Feature/SidebarMenuTest.php` | Test menu: kunci pelan Percuma, sembunyi modul Sekolah bagi Personal, item pemilik tersembunyi bagi Guru KAFA (baharu) | ✅ Sudah Push |
| 243 | 2026-10-19 | `resources/views/kafa_classes/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form | ✅ Sudah Push |
| 244 | 2026-10-19 | `resources/views/kafa_classes/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form | ✅ Sudah Push |
| 245 | 2026-10-19 | `resources/views/kafa_classes/edit.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form | ✅ Sudah Push |
| 246 | 2026-10-19 | `CLAUDE.md` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form | ✅ Sudah Push |
| 247 | 2026-10-19 | `resources/views/students/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam guna SweetAlert | ✅ Sudah Push |
| 248 | 2026-10-19 | `resources/views/students/show.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam guna SweetAlert | ✅ Sudah Push |
| 249 | 2026-10-19 | `resources/views/students/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam guna SweetAlert | ✅ Sudah Push |
| 250 | 2026-10-19 | `resources/views/students/edit.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam guna SweetAlert | ✅ Sudah Push |
| 251 | 2026-10-19 | `resources/views/students/import_summary.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam guna SweetAlert | ✅ Sudah Push |
| 252 | 2026-10-19 | `resources/views/attendances/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 253 | 2026-10-19 | `resources/views/timetable/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form; butang ek-btn tidak berbalut | ✅ Sudah Push |
| 254 | 2026-10-19 | `resources/views/timetable/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form; butang ek-btn tidak berbalut | ✅ Sudah Push |
| 255 | 2026-10-19 | `resources/views/timetable/edit.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form; butang ek-btn tidak berbalut | ✅ Sudah Push |
| 256 | 2026-10-19 | `resources/views/time_slots/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form; butang ek-btn tidak berbalut | ✅ Sudah Push |
| 257 | 2026-10-19 | `resources/css/app.css` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form; butang ek-btn tidak berbalut | ✅ Sudah Push |
| 258 | 2026-10-19 | `resources/views/exams/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam/kunci guna SweetAlert | ✅ Sudah Push |
| 259 | 2026-10-19 | `resources/views/exams/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam/kunci guna SweetAlert | ✅ Sudah Push |
| 260 | 2026-10-19 | `resources/views/exams/results/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam/kunci guna SweetAlert | ✅ Sudah Push |
| 261 | 2026-10-19 | `resources/views/exams/results/enter.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam/kunci guna SweetAlert | ✅ Sudah Push |
| 262 | 2026-10-19 | `resources/views/exams/results/show.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, pengesahan padam/kunci guna SweetAlert | ✅ Sudah Push |
| 263 | 2026-10-19 | `resources/views/exams/results/enter.blade.php` | Betulkan classList.add('') (ralat JS sorotan baris) selepas restyle | ✅ Sudah Push |
| 264 | 2026-10-19 | `resources/views/rph/_field_pair.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 265 | 2026-10-19 | `resources/views/rph/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 266 | 2026-10-19 | `resources/views/rph/create_gabungan.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 267 | 2026-10-19 | `resources/views/rph/edit.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 268 | 2026-10-19 | `resources/views/rph/edit_gabungan.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 269 | 2026-10-19 | `resources/views/rph/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 270 | 2026-10-19 | `resources/views/rph/show.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 271 | 2026-10-19 | `resources/views/achievements/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:; confirm() → data-confirm; layout: pengendali data-confirm global + escape data-name | ✅ Sudah Push |
| 272 | 2026-10-19 | `resources/views/achievements/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:; confirm() → data-confirm; layout: pengendali data-confirm global + escape data-name | ✅ Sudah Push |
| 273 | 2026-10-19 | `resources/views/achievements/show.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:; confirm() → data-confirm; layout: pengendali data-confirm global + escape data-name | ✅ Sudah Push |
| 274 | 2026-10-19 | `resources/views/layout-fb/layout.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:; confirm() → data-confirm; layout: pengendali data-confirm global + escape data-name | ✅ Sudah Push |
| 275 | 2026-10-19 | `CLAUDE.md` | Fasa 3: gaya demo (kelas ek-*), buang dark:; confirm() → data-confirm; layout: pengendali data-confirm global + escape data-name | ✅ Sudah Push |
| 276 | 2026-10-19 | `resources/views/disciplinary/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 277 | 2026-10-19 | `resources/views/disciplinary/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 278 | 2026-10-19 | `resources/views/activities/attendance.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 279 | 2026-10-19 | `resources/views/activities/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 280 | 2026-10-19 | `resources/views/activities/edit.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 281 | 2026-10-19 | `resources/views/activities/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 282 | 2026-10-19 | `resources/views/activities/show.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark: | ✅ Sudah Push |
| 283 | 2026-10-19 | `resources/views/certificates/templates/create.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form | ✅ Sudah Push |
| 284 | 2026-10-19 | `resources/views/certificates/templates/index.blade.php` | Fasa 3: gaya demo (kelas ek-*), buang dark:, padam guna data-delete-form | ✅ Sudah Push |
| 285 | 2026-10-19 | `resources/views/achievements/create.blade.php` | Pulihkan ruang sebelum '>' yang terbuang oleh skrip restyle (teks/ungkapan, bukan class) | ✅ Sudah Push |
| 286 | 2026-10-19 | `resources/views/achievements/index.blade.php` | Pulihkan ruang sebelum '>' yang terbuang oleh skrip restyle (teks/ungkapan, bukan class) | ✅ Sudah Push |
| 287 | 2026-10-19 | `resources/views/attendances/index.blade.php` | Pulihkan ruang sebelum '>' yang terbuang oleh skrip restyle (teks/ungkapan, bukan class) | ✅ Sudah Push |
| 288 | 2026-10-19 | `resources/views/rph/_field_pair.blade.php` | Pulihkan ruang sebelum '>' yang terbuang oleh skrip restyle (teks/ungkapan, bukan class) | ✅ Sudah Push |
| 289 | 2026-10-19 | `resources/views/students/create.blade.php` | Pulihkan ruang sebelum '>' yang terbuang oleh skrip restyle (teks/ungkapan, bukan class) | ✅ Sudah Push |
| 290 | 2026-10-19 | `resources/views/students/edit.blade.php` | Pulihkan ruang sebelum '>' yang terbuang oleh skrip restyle (teks/ungkapan, bukan class) | ✅ Sudah Push |
| 291 | 2026-10-19 | `resources/views/students/import_summary.blade.php` | Pulihkan ruang sebelum '>' yang terbuang oleh skrip restyle (teks/ungkapan, bukan class) | ✅ Sudah Push |

---

> Format status: ⏳ Belum Push &nbsp;|&nbsp; ✅ Sudah Push
