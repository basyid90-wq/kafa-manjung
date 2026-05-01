## Context
- Project: KAFA Manjung (Educational Management System — Malaysia).
- Framework: Laravel 12.x (PHP 8.2+), MVC structure.
- UI: HiStudy Premium Template (Bootstrap 5).
- **UI Language:** ALL labels, error messages, and system text MUST be in Bahasa Melayu.
- **Code/Rules Language:** English only.
- **Also read:** `AGENTS.md` for the full prohibited/required actions list.

---

## 📝 CHANGELOG + GIT — Auto-Commit Rule (MANDATORY)

After EVERY file change session, Claude MUST complete ALL of the following steps — no exceptions:

### Step 1 — Update CHANGELOG.md
Add a new row for every file changed:

| # | Date | File Changed | Description | Status |
|---|------|-------------|-------------|--------|
| N | YYYY-MM-DD | `path/to/file.php` | Brief summary | ⏳ Belum Push |

- `N` = next sequence number from the last row.
- Status MUST start as `⏳ Belum Push`.
- Before committing: check `docs/SECURITY.md`. If editing a connected module: check `docs/SYSTEM_FLOW.md`.

### Step 2 — Verify with git status
Run `git status` to confirm all changed files are tracked. NEVER assume files are staged.

### Step 3 — Stage and commit automatically
Claude made the edits, so Claude MUST stage and commit — do NOT leave this to the user:

```bash
git add <specific files changed>
git commit -m "type: short description of what changed"
```

### Step 4 — Push to remote main
```bash
git push origin claude/strange-jennings-fba0ae:main
```

### Step 5 — Give user VPS commands only
After push, tell the user to run ONLY these on VPS (do NOT repeat localhost commands):

```bash
git pull origin main
php artisan view:clear && php artisan route:clear && php artisan cache:clear
php artisan route:cache && php artisan view:cache
```

> **Rule:** If a new route was added → include `route:cache`. If only views changed → `view:clear` + `view:cache` is enough. Always state which commands are needed and why.

---

## 📚 Project Reference Docs

| File | Purpose |
|------|---------|
| `AGENTS.md` | Universal rules for ALL AI agents (read this first) |
| `CHANGELOG.md` | Change log + git push commands |
| `docs/SECURITY.md` | Security checklist + known recurring issues |
| `docs/SYSTEM_FLOW.md` | System data flow + 22-module dependency map |

---

## 👥 Roles & Access Hierarchy (Spatie RBAC)

| # | Role | Data Scope |
|---|------|-----------|
| 1 | Super Admin | Full access — all districts & schools |
| 2 | Pentadbir | Own district only (`district_id`) |
| 3 | Penyelia KAFA | Own district only (`district_id`) |
| 4 | Guru Besar | Own school only (`school_id`) |
| 5 | Guru KAFA | Own school + own class (`school_id` + `kafa_class_id`) |
| 6 | Ibu Bapa | Own children only (`student_id`) |

**Rule:** Every query MUST be scoped by `school_id` or `district_id` based on the user's role. Never return cross-school or cross-district data without a role check.

---

## 🏷️ Naming Conventions

| Type | Convention | Example |
|------|-----------|---------|
| Controllers | PascalCase + `Controller` | `RphRecordController` |
| Models | PascalCase singular | `ExamResult`, `KafaClass` |
| DB tables | snake_case plural | `kafa_classes`, `exam_results` |
| Routes | kebab-case | `/rph-records`, `/kafa-classes` |
| Blade views | snake_case or kebab-case | per module folder |

---

## 🎨 UI & Styling (STRICT)

- **NO CUSTOM CSS** — Do NOT alter `public/assets/css/styles.css` or add new classes.
- **NO TAILWIND** — Bootstrap 5 and HiStudy theme only.
- **Layout:** Always `@extends('layout.layout')` with `@section('content')`.
- **Dropdowns:** All `bootstrap-select` dropdowns MUST be 50px height (same as text inputs). See `resources/views/layout/layout.blade.php`.
- **Icons:** Use existing template icon classes only. Do NOT substitute a different icon set.
- **Spacing:** Compact layout. No extra `mt-5`, `mb-5`, or unnecessary wrapper divs.

---

## ⚡ JavaScript Rules

- **Framework:** Alpine.js only (`x-data`, `x-show`, `x-on:click`). NOT Vue, React, or jQuery.
- Do NOT import new JS libraries without user approval.

---

## 📊 Table & Data View Rules

- **"No" column:** Every table MUST start with a sequential "No" column.
- **Pagination:** Always `->paginate(10)`. Never more.
- **Action column ("Tindakan"):** Icons only — no text labels. Match existing icon classes.

---

## 📌 Pagination & Scroll State (UX)

- Pass `page` param in all edit/view URLs: `route('x.edit', ['id' => $id, 'page' => request()->page])`
- After save, redirect to same page: `redirect()->route('x.index', ['page' => request()->page])`
- Add row IDs: `<tr id="row-{{ $item->id }}">` and redirect with fragment: `->withFragment('row-'.$item->id)`
- "Kembali / Batal" buttons MUST preserve the `page` parameter.
- Do NOT enable global CSS smooth scrolling — causes jarring page jumps.

---

## ⚙️ Backend Rules

- **Data isolation:** Filter all queries by `school_id` or `district_id` per role.
- **Delete:** Use `data-delete-form` + `data-name` for SweetAlert2 confirmation.
- **PDF display:** NEVER `window.open()` or `<iframe>`. ALWAYS `openPdfBlob(this, url)`.
- **Notifications:** Use `session('success')` or `session('error')`. SweetAlert2 handles display globally.

---

## 🖨️ PDF Generation (STRICT — Jawi/Arabic Support)

- **Library:** mPDF ONLY. NEVER DomPDF. DomPDF cannot render Jawi script.
- **Required mPDF config — DO NOT MODIFY:**
  ```php
  'mode'         => 'utf-8',
  'autoArabic'   => true,
  'default_font' => 'lateef',
  'tempDir'      => storage_path('app/mpdf_temp'),
  ```
- **Display:** All "Cetak" buttons MUST call AJAX → return base64 → display via `openPdfBlob(this, url)` in a PDF.js modal.
- **Template:** Separate `.blade.php` file per PDF (no navbar/sidebar). Use inline CSS only.

---

## 📥 Excel Import / Export

- Package: `maatwebsite/excel`. Import classes in `app/Imports/`, Export in `app/Exports/`.
- Accept `.xlsx` only. Validate MIME type before processing.
- Use `ToCollection` or `ToModel` concern as needed.

---

## 🔲 QR Code

- Package: `simplesoftwareio/simple-qrcode`.
- Output as inline SVG in Blade: `{!! QrCode::size(150)->generate($url) !!}`

---

## 🧪 Testing

- Existing tests: Feature (Auth, Profile) + Unit — in `/tests/`.
- Do NOT modify existing tests without a reason. Run `php artisan test` after any change.
- New routes/controllers → write Feature tests (not Unit tests).
- If unsure about DB structure: ask for migration files or `php artisan migrate:status` output.

---

## 📖 User Manual (MANDATORY UPDATE)

Every time a new module or feature is completed, update the relevant manual file:
`resources/views/manuals/[role].blade.php`

Roles: `guru-kafa`, `guru-besar`, `penyelia-kafa`, `ibu-bapa`, `bendahari-sekolah`, `pentadbir`, `pembekal`

---

## 🚫 Do Not

- Do NOT write paragraphs of explanation. Show code first. One sentence max for notes.
- Do NOT apologize when fixing bugs. Just provide the fix.
- Do NOT assume DB structure. Ask for migration files if unsure.
- Do NOT leave `dd()`, `dump()`, `var_dump()`, or `console.log()` in code.
