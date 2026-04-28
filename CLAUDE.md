## Context
- Project: KAFA Manjung (Educational Management).
- Framework: Laravel 12.x (PHP 8.2+), MVC structure.
- UI: HiStudy Premium Template (Bootstrap 5).
- Language: Bahasa Melayu STRICTLY for all UI labels, errors, and system messages.

## 🎨 UI & Styling (STRICT RULES)
- ❌ **NO CUSTOM CSS:** Do NOT alter `public/assets/css/styles.css` or invent new classes. 
- ⚠️ **DROPDOWN SIZING:** All `bootstrap-select` dropdowns MUST match text field height exactly (Height: 50px). Refer to `layout.blade.php`.
- ❌ **NO TAILWIND:** Stick to Bootstrap 5 and the HiStudy theme.
- **Layout:** Always use `@extends('layout.layout')` and `@section('content')`.
- **Spacing:** Keep design compact. Avoid excessive margins (`mt--`) or unnecessary row wraps.

## 📊 Table & Data View Rules
- **Column "No":** Every table MUST start with a "No" column for sequence numbering.
- **Pagination:** STRICTLY limit to 10 rows per page (`->paginate(10)`). NO long vertical scrolling.
- **Action Column ("Tindakan"):** Use ICONS ONLY for edit/delete actions. Match existing template icon classes.

## 📌 State & Scroll Preservation (UX RULES)
- **Pagination State:** MUST maintain page position after Edit, View, or Cancel actions.
  - *Implementation:* Pass the `page` parameter in URLs: `route('users.edit', ['user' => $id, 'page' => request()->page])`.
  - *Redirect:* After saving, redirect back to the specific page: `return redirect()->route('users.index', ['page' => request()->page]);`.
- **Scroll Retention:** JANGAN biarkan page melompat ke atas selepas kemaskini.
  - *Method:* Use row IDs (`<tr id="row-{{ $item->id }}">`). Redirect using fragments: `->withFragment('row-'.$item->id)`.
  - *Buttons:* Ensure "Kembali/Batal" buttons preserve the `page` parameter.

## ⚙️ Backend & Workflow Playbook
- **Data Isolation:** Data MUST be filtered by `school_id` or `district_id` based on user role (Spatie RBAC).
- **Delete Actions:** ALWAYS use `data-delete-form` and `data-name` attributes for automated SweetAlert2 handling.
- **PDF Viewing:** ❌ NEVER use `window.open` or direct `<iframe>`. ALWAYS use `openPdfBlob(this, url)` for the PDF.js overlay to prevent IDM hijacking.
- **Notifications:** Use `session('success')` or `session('error')`. SweetAlert2 is handled globally.

## 🚫 Known Failure Modes & Do Not
- ❌ Do not enable global smooth scrolling. It causes jarring jumps.
- ❌ Do not write paragraphs of explanation. Show code first, keep notes to 1 sentence.
- ❌ If I ask to fix a bug, do not apologize. Just provide the fix.
- ❌ Do not assume database structure. Ask for migration files if unsure.

## 📖 Panduan Pengguna (WAJIB DIKEMASKINI)
- **SOP Wajib:** Setiap kali modul atau fungsi baharu disiapkan, anda WAJIB mengemaskini fail `resources/views/manuals/[role].blade.php` yang berkaitan untuk memastikan Panduan Pengguna sentiasa memaparkan ciri terkini.
- Fail panduan: `guru-kafa`, `guru-besar`, `penyelia-kafa`, `ibu-bapa`, `bendahari-sekolah`, `pentadbir`, `pembekal`.

## 🖨️ PDF Generation Rules (STRICT STANDARD & JAWI SUPPORT)
- ⚠️ **Library (WAJIB mPDF):** JANGAN sesekali cadangkan atau gunakan DomPDF. Sistem ini MESTI menggunakan `mPDF` kerana sokongan tulisan Jawi (RTL).
- 🚨 **Konfigurasi Jawi (CRITICAL - DO NOT TOUCH):** Semasa *initialize* objek mPDF di Controller, WAJIB sertakan parameter berikut tanpa diubah/dibuang: `'mode' => 'utf-8'`, `'autoArabic' => true`, dan `'default_font' => 'lateef'`. 
- **Elak Ralat $cw (Font/Cache):** Sentiasa tetapkan konfigurasi `tempDir` kepada folder yang *writable* (contoh: `storage_path('app/mpdf_temp')`) semasa *initialize* objek PDF.
- **Frontend / Anti-IDM Hijack:** JANGAN sesekali guna `<a target="_blank">`, `window.open()`, atau direct `<iframe>` untuk paparan PDF.
- **Wajib Guna PDF.js:** Semua butang "Cetak" WAJIB memanggil fungsi AJAX untuk tarik base64 data, dan paparkan guna `PDF.js` dalam *modal/overlay* (rujuk fungsi `openPdfBlob(this, url)`).
- **Template Berasingan:** Gunakan fail `.blade.php` khusus untuk PDF (tanpa navbar/sidebar) berserta CSS inline yang ringkas untuk elak layout pecah.