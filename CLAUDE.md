## Context
- Project: **eKafa Online** — multi-tenant SaaS for KAFA schools in Malaysia (pivoted from the KAFA Manjung district system in Oct 2026; the old system is preserved at git tag `v1-jabatan`).
- **Tenant = School.** Plans: Free (3 classes × 40 students), Personal (one teacher, own classes only), Sekolah (Guru Besar + teachers + parents). Billing: Bayarcash, monthly.
- **Active branch:** `saas`. Do NOT push to `main` until the SaaS launch (main still holds the old jabatan deployment).
- Framework: Laravel 12.x (PHP 8.2+), MVC structure.
- UI: **Flowbite + Tailwind CSS** (migrated from HiStudy/Bootstrap 5 — completed May 2026).
- **UI Language:** ALL labels, error messages, and system text MUST be in Bahasa Melayu.
- **Code/Rules Language:** English only.
- **Also read:** `AGENTS.md` for the full prohibited/required actions list.

---

## 🤖 AI Agents & CLI Tools

This project is maintained using the following AI coding tools. All agents MUST follow the same rules in this file and `AGENTS.md`.

| Tool | Type | Role |
|------|------|------|
| **Claude Code** | Anthropic CLI (`claude`) | Primary agent — architecture, full-file rewrites, backend logic |
| **OpenAI Codex** | OpenAI CLI (`codex`) | Secondary agent — targeted edits, code generation, refactoring |
| **Google Gemini** | Google CLI (`gemini`) | Secondary agent — code review, analysis, debugging assistance |

### Rules for ALL agents (Claude + Codex)
- Read `CLAUDE.md` + `AGENTS.md` before any edit.
- Update `CHANGELOG.md` after every change session.
- Commit + push after every session (see git rules below).
- NEVER break the Flowbite/Tailwind UI pattern.
- NEVER introduce new packages without user approval.
- NEVER use Bootstrap, jQuery, Vue, React, or DomPDF.

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

### Step 4 — Push to the SaaS branch
```bash
git push origin saas
```
> ⚠️ Do NOT push to `main` during the SaaS rebuild — `main` is the old jabatan system. Deployment target will be Hostinger (shared hosting + SSH); deploy steps will be documented once set up.

### Step 5 — Give user VPS commands only
After push, tell the user to run ONLY these on VPS (do NOT repeat localhost commands):

```bash
git pull origin main
php artisan view:clear && php artisan cache:clear
```

> **Rule:** If a new route was added → also run `php artisan route:clear && php artisan route:cache`. If only views changed → `view:clear` is enough. After ANY Tailwind class addition → `npm run build` is required on VPS.

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
| 1 | Super Admin | Platform owner — all schools (tenants) |
| 2 | Guru Besar | Own school only (`school_id`) — owner of a Sekolah-plan tenant |
| 3 | Guru KAFA | Own school + own class (`school_id` + `kafa_class_id`) |
| 4 | Ibu Bapa | Own children only (`student_id`) |

Removed in the SaaS pivot (do NOT reintroduce): Pentadbir, Penyelia KAFA, Pembekal, Bendahari Sekolah, the `districts` table and the book-ordering module.

**Tenant isolation (MANDATORY):**
- School-owned models use the `App\Models\Concerns\BelongsToSchool` trait — a global scope that limits Guru Besar / Guru KAFA to their own `school_id` (incl. route-model binding) and fills `school_id` on create. Add it to every new model that has a `school_id`.
- In controllers, guard records with `$this->authorizeSchool($record->school_id)` (base `Controller`) or `$user->canAccessSchool($id)`. Never trust a `school_id`, `kafa_class_id`, `teacher_id` etc. from the request without checking it belongs to the user's school (`Rule::exists(...)->where('school_id', ...)`).
- `Rule::exists` / `DB::table()` bypass the global scope — scope them manually.
- Cover new modules in `tests/Feature/TenantIsolationTest.php`.

**Plan gating (MANDATORY for new modules):**
- Plans, limits and module→plan mapping live in `config/plans.php` (Free < Personal < Sekolah). Change limits there, never hard-code them.
- Gate every module route with `->middleware('plan:<module_key>')`; locked modules redirect to `/langganan` (upsell). The Pengurusan grid locks tiles automatically from the route's `plan:` middleware.
- In code use `$user->canUse('module')`, `$school->allows('module')`, `$school->limit('max_classes')`, `$school->canAddClass()`, `$school->studentPlacesLeft($classId)`.
- `schools.plan / plan_expires_at / type / owner_id` are NOT mass-assignable — change them only via the Super Admin plan editor or the billing flow (`forceFill`).
- Workspace owner = role **Guru Besar**, also for Personal workspaces (shown as "Guru (Personal)" via `$user->roleLabel()`). School-only features are locked by plan, not by role.
- Cover new gates in `tests/Feature/PlanGatingTest.php`.

**Sign-up, verification & invites:**
- Self-signup at `/daftar` creates a Free workspace (school row) owned by the new user (role Guru Besar). Staff must verify their e-mail (`verified` middleware on the main route group) — production needs working `MAIL_*` settings.
- Teachers join via `/jemputan/{token}` (InvitationController; only the sha256 of the token is stored). A Personal-workspace owner who accepts is merged into the school by `App\Services\WorkspaceMerger` (blocked while MyKid duplicates exist).
- App locale is `ms`; translations live in `lang/ms/`. Every new validation attribute should get a Malay name in `lang/ms/validation.php`.

**Billing (Bayarcash, monthly):**
- Prices live in `config/plans.php` (`price`, RM/month). Credentials only in `.env` (`BAYARCASH_*`, see `.env.example`) — never commit or paste real keys.
- Flow: `POST /langganan/bayar` (owner only) → `App\Services\Bayarcash::createPaymentIntent()` → Bayarcash page → `POST /webhook/bayarcash` (server callback) and `/langganan/bayar/kembali` (return URL). Both are CSRF-exempt and trusted ONLY after HMAC-SHA256 checksum verification.
- Plans are activated exclusively by `Payment::markPaid()` (idempotent; renewals extend from the current expiry; amount must match). Never activate a plan from browser input.
- `php artisan plans:remind` (scheduled daily 09:00) e-mails owners 7 and 1 days before expiry — Hostinger needs a cron for `php artisan schedule:run`.
- Cover billing changes in `tests/Feature/BillingTest.php` (use `Http::fake`, never real gateway calls).

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

## 🎨 UI & Styling (STRICT — Flowbite Only)

> 🚨 **ONE SOURCE OF TRUTH FOR UI COMPONENTS:**
> **https://flowbite.com/docs/components**
>
> Every UI component (buttons, modals, tabs, badges, cards, tables, forms, alerts, dropdowns, pagination, file inputs, datepickers) MUST be taken from this URL.
> Do NOT invent custom component patterns. Do NOT use Daisy UI, Shadcn, Headless UI, or any other library.

> ⚠️ UI has been **fully migrated to Flowbite + Tailwind CSS**. Do NOT use Bootstrap or HiStudy classes.

### 🔒 VPS-Safe CSS Rule (CRITICAL)
`public/build/` is gitignored — Tailwind CSS is NOT rebuilt on VPS automatically.

**Rule: Any NEW Tailwind utility class that is not already used in the codebase WILL NOT render on VPS.**

| Situation | Correct approach |
|-----------|-----------------|
| New gradient / shadow / custom colour | Use **inline `style="..."`** — always works |
| New spacing (`py-10`, `mb-14`, etc.) that hasn't been used before | Use inline `style="padding:..."` |
| Standard classes already in codebase (`flex`, `grid`, `text-sm`, `bg-white`, `rounded-lg`, etc.) | Safe to use as Tailwind class |
| Responsive prefix on NEW class (`lg:grid-cols-5`) | Use `<style>@media(...){...}</style>` block instead |

**Bottom line: when in doubt → inline style. Never assume a class is compiled.**

### Layouts
- **Authenticated pages:** `@extends('layout-fb.layout')` with `@section('content')`
- **Public pages (login):** `@extends('layout-fb.auth')` with `@section('content')`
- **Landing page (`/`, `/login`):** `resources/views/auth/login.blade.php` is a standalone marketing page (own `<head>`, generated from the Claude Design draft `scratch/ekafa-landing.html`). It uses many Tailwind classes not used elsewhere → `npm run build` is REQUIRED on every deploy. Keep the login form field names (`login_type`, `login_id`, `password`, `remember`).
- **PDF templates:** Standalone `.blade.php` — no layout, inline CSS only

### Standard Components (`ek-*` classes — USE THESE)

Design source: the Claude Design demo (`/demo`, `resources/views/demo/index.blade.php`). Light theme only — **dark mode is retired**: do NOT add `dark:` classes (leftovers in old views are inert and get removed module by module). Font: Inter.

The standard classes live in `resources/css/app.css` (`@layer components`, prefix `ek-`). Use them instead of long utility strings; extend that file (not per view) when a new shared pattern is needed. Any change there needs `npm run build`. Tailwind tree-shakes `@layer components`: an `ek-*` class used in a view for the first time only exists after the next `npm run build`, so always rebuild before checking a restyled page.

| Purpose | Class |
|---|---|
| Buttons | `ek-btn-primary`, `ek-btn-secondary`, `ek-btn-danger`, `ek-btn-icon` (icon-only, e.g. Tindakan column) |
| Form | `ek-label`, `ek-input` (input/select/textarea), `ek-help`, `ek-error` |
| Card / headings | `ek-card`, `ek-card-title`, `ek-card-sub`, `ek-page-title`, `ek-page-sub`, `ek-icon-tile` |
| Table | `ek-table-wrap` > `div.overflow-x-auto` > `table.ek-table` (styles thead/tbody cells) |
| Badge | `ek-badge` + `ek-badge-green` / `-yellow` / `-red` / `-blue` / `-gray` |
| Sidebar | `ek-nav-heading`, `ek-nav-link` (+ `is-active`) — layout only |

```html
<div class="ek-table-wrap">
    <div class="overflow-x-auto">
        <table class="ek-table">
            <thead><tr><th>No</th><th>Nama</th><th>Tindakan</th></tr></thead>
            <tbody><tr><td>1</td><td>...</td><td><a class="ek-btn-icon" title="Edit">...svg...</a></td></tr></tbody>
        </table>
    </div>
</div>
<span class="ek-badge ek-badge-green">Aktif</span>
```

Page header pattern: `<p class="ek-page-sub">…</p><h1 class="ek-page-title">…</h1>`. The layout header already shows the `@section('title')` and school name.

### Custom Modals (NO Bootstrap)
```html
<div id="myModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
        ...
        <button onclick="document.getElementById('myModal').classList.add('hidden')">Tutup</button>
    </div>
</div>
```

### Custom Tabs (NO Bootstrap)
```javascript
function switchTab(tab) {
    ['tab1','tab2'].forEach(function(t) {
        document.getElementById('panel-' + t).classList.add('hidden');
        document.getElementById('tab-' + t).classList.remove('border-blue-600','text-blue-600');
        document.getElementById('tab-' + t).classList.add('border-transparent','text-gray-500');
    });
    document.getElementById('panel-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.remove('border-transparent','text-gray-500');
    document.getElementById('tab-' + tab).classList.add('border-blue-600','text-blue-600');
}
```

### Radio Pills (replacing Bootstrap btn-group)
```html
<label class="flex-1 cursor-pointer">
    <input type="radio" class="peer sr-only" name="field" value="A">
    <span class="flex items-center justify-center px-2 py-1 text-xs font-medium border border-gray-300 rounded-lg
                 peer-checked:bg-green-600 peer-checked:border-green-600 peer-checked:text-white transition-colors">A</span>
</label>
```

### Jawi Font Support
```html
<style>@font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }</style>
<p dir="rtl" style="font-family:'Lateef',serif;font-size:1.1em;">{{ $jawiText }}</p>
```

---

## ⚡ JavaScript Rules

- **Framework:** Alpine.js only (`x-data`, `x-show`, `x-on:click`). NOT Vue, React, or jQuery.
- **NO `@push('scripts')`** — use direct `<script>` tags before `@endsection`.
- **AJAX:** Use vanilla `fetch()` only. No jQuery `$.ajax()`.
- **DOM:** Use `classList.add/remove('hidden')` for show/hide. No jQuery `.show()/.hide()`.
- Do NOT import new JS libraries without user approval.

---

## 📊 Table & Data View Rules

- **"No" column:** Every table MUST start with a sequential "No" column.
- **Pagination:** Always `->paginate(10)`. The global pagination view is `vendor/pagination/flowbite.blade.php` — do NOT override per-view.
- **Action column ("Tindakan"):** Icons only — no text labels. Use inline SVG icons.

---

## 📌 Pagination & Scroll State (UX)

- Pass `page` param in all edit/view URLs: `route('x.edit', ['id' => $id, 'page' => request()->page])`
- After save, redirect to same page: `redirect()->route('x.index', ['page' => request()->page])`
- Add row IDs: `<tr id="row-{{ $item->id }}">` and redirect with fragment: `->withFragment('row-'.$item->id)`
- "Kembali / Batal" buttons MUST preserve the `page` parameter.
- Do NOT enable global CSS smooth scrolling — causes jarring page jumps.

---

## ⚙️ Backend Rules

- **Data isolation:** Filter all queries by `school_id` (tenant). See "Tenant isolation" above.
- **Delete:** Use `data-delete-form` + `data-name` for SweetAlert2 confirmation (handler is global in `layout-fb/layout.blade.php`).
- **PDF display:** NEVER `window.open()` or `<iframe>`. ALWAYS `openPdfBlob(this, url)` (defined globally in `layout-fb/layout.blade.php`).
- **Notifications:** Use `session('success')` or `session('error')`. SweetAlert2 handles display globally in `layout-fb/layout.blade.php`.

---

## 🏗️ layout-fb/layout.blade.php — What's Included Globally

The following are already provided by `layout-fb/layout.blade.php` — do NOT re-add per-view:

| Feature | How to use |
|---------|-----------|
| SweetAlert2 | `session('success')` / `session('error')` auto-popup |
| Delete confirmation | `<form data-delete-form data-name="nama item">` |
| Other confirmations | `data-confirm="Mesej?"` on a `<form>` or its submit `<button>` (SweetAlert2). Never use `confirm()` |
| PDF viewer | `openPdfBlob(this, url)` — returns JSON `{data: base64, filename}` |
| PDF base64 render | `renderPdfBase64(base64string)` |
| PDF close | `closePdfViewer()` |
| Alpine.js | Available globally |
| Flowbite JS | Available globally |

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
- **Controller must return JSON:** `return response()->json(['data' => base64_encode($pdf), 'filename' => 'file.pdf']);`
- **Display:** All "Cetak" buttons MUST call `openPdfBlob(this, route('x.pdf', $id))`.
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

## ⚠️ VPS Deploy Checklist

After every push, tell user to run on VPS:

```bash
git pull origin main
php artisan view:clear && php artisan cache:clear
```

**Additional if needed:**
- New route added → `php artisan route:clear && php artisan route:cache`
- New Tailwind classes used → `npm run build` (CRITICAL — `public/build/` is gitignored)
- New config changed → `php artisan config:clear`

---

## 🚫 Do Not

- Do NOT write paragraphs of explanation. Show code first. One sentence max for notes.
- Do NOT apologize when fixing bugs. Just provide the fix.
- Do NOT assume DB structure. Ask for migration files if unsure.
- Do NOT leave `dd()`, `dump()`, `var_dump()`, or `console.log()` in code.
- Do NOT use `@extends('layout.layout')` — old Bootstrap layout, no longer in use.
- Do NOT use Bootstrap classes (`btn`, `card`, `modal`, `nav-tabs`, `form-control`, etc.).
- Do NOT use jQuery (`$()`, `$.ajax()`, `.selectpicker()`) — use vanilla JS only.
- Do NOT add `@push('scripts')` / `@endpush` — use direct `<script>` before `@endsection`.
- Do NOT call `window.open()` or use `<iframe>` for PDF — use `openPdfBlob()` only.
- Do NOT use any UI component that is NOT from **https://flowbite.com/docs/components**.
- Do NOT use Daisy UI, Shadcn, Headless UI, Radix, Flowbite React/Vue, or any other component library.
- Do NOT use new Tailwind utility classes without checking if they are VPS-safe (already compiled). Use inline style if unsure.
- Do NOT introduce any CSS framework other than Tailwind CSS v3.
