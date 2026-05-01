# AGENTS.md — KAFA Manjung Project Rules

> **ALL AI agents MUST read this file before making any changes.**
> These rules are NON-NEGOTIABLE. Do not skip, reinterpret, or work around them.
> When in doubt: STOP and ask the user.

---

## ⛔ PROHIBITED ACTIONS — NEVER DO THESE

```
NEVER alter public/assets/css/styles.css
NEVER add new CSS classes that don't exist in the HiStudy theme
NEVER use Tailwind CSS
NEVER use DomPDF — mPDF ONLY (Jawi/Arabic script support required)
NEVER use window.open() or <iframe> for PDF display
NEVER use <a target="_blank"> for PDF links
NEVER use jQuery for new logic — Alpine.js only
NEVER import new JS libraries without user approval
NEVER enable CSS smooth scrolling globally
NEVER return data without filtering by school_id or district_id (role-based)
NEVER delete a Student, School, or Subject record without checking dependent data first
NEVER leave dd(), dump(), var_dump(), or console.log() in committed code
```

---

## ✅ ALWAYS DO THESE

```
ALWAYS use mPDF with: mode=utf-8, autoArabic=true, default_font=lateef
ALWAYS use openPdfBlob(this, url) for PDF display buttons
ALWAYS filter queries by school_id or district_id based on user role
ALWAYS use @csrf in every form
ALWAYS use SweetAlert2 via data-delete-form + data-name for delete actions
ALWAYS paginate with ->paginate(10) — never more
ALWAYS start every table with a "No" column for row numbering
ALWAYS use icons only (no text) in the "Tindakan" action column
ALWAYS use session('success') or session('error') for notifications
ALWAYS use Bootstrap 5 classes — never invent new ones
ALWAYS extend layout.layout and use @section('content')
```

---

## 🎨 UI & Styling Rules

- **Template:** HiStudy Premium (Bootstrap 5). Match existing styles exactly.
- **Dropdowns:** All `bootstrap-select` dropdowns MUST be 50px height — same as text inputs. Do NOT change this.
- **Icons:** Use the exact same icon classes already used in the project. Do NOT substitute with a different icon library.
- **Layout:** `@extends('layout.layout')` — no exceptions.
- **Spacing:** Compact. No extra `mt-5`, `mb-5`, or unnecessary wrapper `<div>` rows.

---

## 🖨️ PDF Rules (STRICT)

| Rule | Correct | Wrong |
|------|---------|-------|
| Library | `mPDF` | DomPDF ❌ |
| mPDF config | `mode=utf-8, autoArabic=true, default_font=lateef` | Any other config ❌ |
| Display | `openPdfBlob(this, url)` via AJAX | `window.open()`, `<iframe>`, `<a target="_blank">` ❌ |
| Template | Separate `.blade.php` (no navbar/sidebar) | Main layout ❌ |
| Temp dir | `storage_path('app/mpdf_temp')` | Default system temp ❌ |

This project renders **Jawi (Arabic-script Malay)**. mPDF is the ONLY library that supports this. DomPDF will break Jawi text completely.

---

## 🔗 Module Dependency Rules

Before editing any module, check `docs/SYSTEM_FLOW.md` for dependent modules.

**High-risk modules — check dependencies before ANY edit:**

| Module You Edit | Also Check These |
|----------------|-----------------|
| Student | Attendance, ExamResult, Certificate, DisciplinaryRecord, Achievement |
| KafaClass | Student, Attendance, Timetable, RPH |
| Subject | Exam, Timetable, RPH |
| School | All modules (school_id is the root filter) |
| ExamResult | ParentResult, Report |
| User | RPH records, Attendance records |

**Rule:** If you edit a module that has dependents in the table above, you MUST verify the dependent modules still work correctly after your change.

---

## 🔒 Security Rules

1. **Data Isolation:** Every query touching student/class/financial data MUST be scoped:
   - Guru KAFA → filter by `school_id` AND `kafa_class_id`
   - Guru Besar → filter by `school_id`
   - Pentadbir / Penyelia KAFA → filter by `district_id`
   - Super Admin → no filter required

2. **Input Validation:** Every `store()` and `update()` method MUST call `$request->validate([...])`.

3. **File Uploads:** Validate MIME type and size. Accept `.xlsx` for imports, images for profiles.

4. **No Raw Queries:** Use Eloquent ORM. Never concatenate user input into SQL strings.

---

## 📋 CHANGELOG Rule

After EVERY file change, update `CHANGELOG.md` in the project root.
Add a new row to the log table:

```
| N | YYYY-MM-DD | path/to/changed/file.php | What was changed | ⏳ Belum Push |
```

- `N` = next sequence number
- Use today's date
- Status MUST start as `⏳ Belum Push`
- Do NOT mark as pushed — only the user does that

---

## 🏷️ Naming Conventions

| Type | Convention | Example |
|------|-----------|---------|
| Controllers | PascalCase + Controller | `RphRecordController` |
| Models | PascalCase singular | `ExamResult`, `KafaClass` |
| DB tables | snake_case plural | `kafa_classes`, `exam_results` |
| Routes | kebab-case | `/rph-records`, `/kafa-classes` |

---

## 📋 Before Every Edit — Quick Checklist

```
[ ] Did I read the module's dependencies in docs/SYSTEM_FLOW.md?
[ ] Am I using Bootstrap 5 classes only (no Tailwind, no custom CSS)?
[ ] If PDF is involved — am I using mPDF + openPdfBlob()?
[ ] Is every query filtered by school_id or district_id?
[ ] Is there @csrf in every form?
[ ] Will I update CHANGELOG.md after this edit?
```

---

## 📚 Reference Docs

| File | Purpose |
|------|---------|
| `CLAUDE.md` | Full project rules (Claude-specific + general) |
| `CHANGELOG.md` | Log of all changes + git push commands |
| `docs/SECURITY.md` | Security checklist + recurring issues |
| `docs/SYSTEM_FLOW.md` | Data flow + 22-module dependency map |
