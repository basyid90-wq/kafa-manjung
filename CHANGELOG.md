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

---

> Format status: ⏳ Belum Push &nbsp;|&nbsp; ✅ Sudah Push
