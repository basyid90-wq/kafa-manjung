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

---

> Format status: ⏳ Belum Push &nbsp;|&nbsp; ✅ Sudah Push
