# SECURITY CHECKLIST — KAFA Manjung

> Semak senarai ini sebelum setiap `git push`. Tanda ✅ = selamat, ❌ = perlu fix dulu.

---

## 🔒 1. Data Isolation (KRITIKAL)

Setiap query MESTI dihadkan mengikut role pengguna. Kegagalan ini boleh bocorkan data sekolah/daerah lain.

| Role | Filter Wajib | Contoh |
|---|---|---|
| Super Admin | Tiada (akses penuh) | — |
| Pentadbir | `district_id` | `->where('district_id', auth()->user()->district_id)` |
| Penyelia KAFA | `district_id` | sama seperti Pentadbir |
| Guru Besar | `school_id` | `->where('school_id', auth()->user()->school_id)` |
| Guru KAFA | `school_id` + `kafa_class_id` | `->where('school_id', ...)->where('kafa_class_id', ...)` |
| Ibu Bapa | `student_id` (anak sendiri) | `->where('parent_id', auth()->id())` |

**Semak:** Adakah setiap Controller method ada filter role sebelum return data?

---

## 🛡️ 2. Autentikasi & Autorisasi

- [ ] Semua route dilindungi middleware `auth` (kecuali route awam seperti sijil verify)
- [ ] Route sensitif ada middleware `role:` Spatie yang betul
- [ ] Tiada route yang boleh diakses tanpa login secara tidak sengaja
- [ ] `@can` / `@role` digunakan dalam Blade untuk sembunyikan UI (bukan gantikan middleware)

---

## 🧹 3. Input Validation

- [ ] Semua `store()` dan `update()` method ada `$request->validate([...])`
- [ ] File upload (gambar, Excel) dihadkan jenis fail: `mimes:jpg,png,xlsx`
- [ ] File upload dihadkan saiz: `max:2048` (2MB) atau sesuai
- [ ] Tiada input pengguna dimasukkan terus ke query tanpa Eloquent/binding

---

## 🔑 4. CSRF & Form Security

- [ ] Semua form POST/PUT/DELETE ada `@csrf`
- [ ] Form DELETE guna `@method('DELETE')` + `data-delete-form` (SweetAlert2)
- [ ] Tiada form yang submit ke URL luar tanpa sebab

---

## 📁 5. Fail & PDF Security

- [ ] PDF dijana melalui `openPdfBlob()` — BUKAN `window.open` atau `<iframe>`
- [ ] Fail PDF tidak disimpan kekal di `public/` (guna `storage/` + stream)
- [ ] Import Excel validate format sebelum process — elak inject formula (`=CMD(...)`)

---

## 🔐 6. Environment & Config

- [ ] `.env` tidak di-commit ke Git (semak `.gitignore`)
- [ ] `APP_DEBUG=false` di VPS/production
- [ ] `APP_ENV=production` di VPS
- [ ] Key `APP_KEY` tidak dikongsi atau didedahkan

---

## ⚠️ 7. Isu Berulang — Senarai Hitam

Perkara ini PERNAH atau BOLEH berlaku — elak setiap masa:

| Isu | Punca | Cara Elak |
|---|---|---|
| Data sekolah lain terpapar | Query tanpa filter `school_id` | Sentiasa tambah `->where('school_id', ...)` |
| PDF dibuka terus (IDM hijack) | `window.open()` atau `<a target="_blank">` | Guna `openPdfBlob(this, url)` sahaja |
| DomPDF digunakan | Cadangan lalai AI | WAJIB mPDF dengan config Jawi |
| Smooth scroll menyebabkan lompat | CSS `scroll-behavior: smooth` | Jangan enable global |
| Page lompat ke atas selepas edit | Redirect tanpa `page` param | Sentiasa pass `page` + fragment `#row-id` |

---

## 🚀 8. Checklist Sebelum Push

```
[ ] Semua query ada filter role/school_id
[ ] Tiada dd(), dump(), var_dump() tertinggal dalam kod
[ ] Tiada console.log() tertinggal dalam JS/Alpine
[ ] php artisan test — semua test pass
[ ] Panduan pengguna (manuals/*.blade.php) dikemaskini jika modul baru
[ ] CHANGELOG.md dikemaskini dengan perubahan terkini
```
