@section('title', 'Log Masuk')
@extends('layout-fb.auth')

@section('content')

{{-- ══════════════════════════════════════════════════════════
     HERO HEADER — full-width gradient, all inline styles (VPS-safe)
═══════════════════════════════════════════════════════════ --}}
<div style="background:linear-gradient(135deg,#0c1a4f 0%,#1a56db 55%,#3b82f6 100%);
            position:relative;overflow:hidden;">

    {{-- Background decoration circles --}}
    <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none;">
        <div style="position:absolute;top:-80px;right:-80px;width:380px;height:380px;
                    background:rgba(255,255,255,0.05);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;
                    background:rgba(255,255,255,0.04);border-radius:50%;"></div>
        <div style="position:absolute;top:50%;left:30%;width:180px;height:180px;
                    background:rgba(255,255,255,0.025);border-radius:50%;transform:translateY(-50%);"></div>
    </div>

    <div style="position:relative;max-width:72rem;margin:0 auto;
                padding:3rem 1.5rem 5.5rem;text-align:center;">

        {{-- Logo --}}
        <div style="display:flex;justify-content:center;margin-bottom:1.25rem;">
            <div style="padding:0.875rem;border-radius:1.25rem;
                        background:rgba(255,255,255,0.15);
                        box-shadow:0 0 0 1px rgba(255,255,255,0.1);">
                <img src="{{ asset('template/perak.png') }}" alt="Logo APKM"
                     style="height:64px;width:auto;filter:brightness(0) invert(1);">
            </div>
        </div>

        {{-- "Sistem Aktif" badge --}}
        <div style="display:inline-flex;align-items:center;gap:6px;
                    padding:5px 14px;border-radius:999px;
                    background:rgba(255,255,255,0.15);
                    color:rgba(219,234,254,0.95);
                    font-size:0.75rem;font-weight:600;
                    margin-bottom:1rem;letter-spacing:0.03em;">
            <span style="width:7px;height:7px;background:#4ade80;border-radius:50%;
                         display:inline-block;box-shadow:0 0 6px #4ade80;"></span>
            Sistem Aktif &mdash; Daerah Manjung, Perak
        </div>

        {{-- Main title --}}
        <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;color:#ffffff;
                   letter-spacing:-0.03em;line-height:1.1;margin-bottom:0.75rem;">
            Aplikasi Pengurusan<br>
            <span style="color:#93c5fd;">KAFA Manjung</span>
        </h1>

        {{-- Subtitle --}}
        <p style="font-size:1rem;font-weight:400;color:rgba(186,222,255,0.88);
                  max-width:520px;margin:0 auto;line-height:1.6;">
            Sistem bersepadu untuk pentadbir, guru, dan ibu bapa —<br>
            dibangunkan khas untuk daerah Manjung, Perak.
        </p>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MAIN CONTENT — cards float up over the hero
═══════════════════════════════════════════════════════════ --}}
<div class="bg-gray-50 dark:bg-gray-900" style="min-height:100vh;">
    <div class="max-w-6xl mx-auto px-4 pb-10" style="margin-top:-60px;">

        {{-- Two-column grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 items-start">

            {{-- ══ LEFT: Login Card (2/5) ══ --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden"
                     style="box-shadow:0 20px 60px rgba(0,0,0,0.15);">

                    {{-- Card top — tab switcher on blue --}}
                    <div style="background:linear-gradient(135deg,#1a56db,#3b82f6);"
                         class="px-5 pt-5 pb-8">
                        <div class="flex gap-1.5 p-1 rounded-xl" style="background:rgba(255,255,255,0.15);">
                            <button type="button" id="tab-staff" onclick="switchLoginType('staff')"
                                    class="flex-1 py-2 text-sm font-semibold rounded-lg transition-all"
                                    style="background:#fff;color:#1a56db;box-shadow:0 1px 4px rgba(0,0,0,0.15);">
                                🏢 Kakitangan
                            </button>
                            <button type="button" id="tab-parent" onclick="switchLoginType('parent')"
                                    class="flex-1 py-2 text-sm font-semibold rounded-lg transition-all"
                                    style="color:rgba(255,255,255,0.85);">
                                👨‍👩‍👧‍👦 Ibu Bapa
                            </button>
                        </div>
                    </div>

                    {{-- Form area — overlaps blue header slightly --}}
                    <div class="px-6 pb-6 rounded-t-2xl bg-white dark:bg-gray-800"
                         style="margin-top:-16px;">

                        {{-- Lock icon header --}}
                        <div class="flex items-center gap-3 mb-5">
                            <div class="p-2.5 rounded-xl" style="background:#eff6ff;">
                                <svg class="w-5 h-5" style="color:#1a56db;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Log Masuk</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Sila masukkan maklumat anda</p>
                            </div>
                        </div>

                        {{-- Session status --}}
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="login_type" id="login_type"
                                   value="{{ old('login_type', 'staff') }}">

                            {{-- Login ID --}}
                            <div>
                                <label for="login_id" id="login_label"
                                       class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">
                                    Alamat Emel
                                </label>
                                <input type="{{ old('login_type') === 'parent' ? 'text' : 'email' }}"
                                       id="login_id" name="login_id"
                                       value="{{ old('login_id') }}" required autofocus
                                       placeholder="{{ old('login_type') === 'parent' ? '890101-10-5555' : 'nama@sekolah.edu.my' }}"
                                       class="w-full text-sm rounded-xl border bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring-2 focus:border-transparent outline-none transition-all px-3.5 py-2.5 dark:placeholder-gray-500
                                              @error('login_id') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror"
                                       style="@error('login_id')@else focus:border-color:#1a56db;@enderror">
                                @error('login_id')
                                <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label for="password-field"
                                       class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">
                                    Kata Laluan
                                </label>
                                <div class="relative">
                                    <input type="password" id="password-field" name="password"
                                           required placeholder="••••••••••"
                                           class="w-full text-sm rounded-xl border bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring-2 focus:border-transparent outline-none transition-all px-3.5 py-2.5 pr-10
                                                  @error('password') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror">
                                    <button type="button" onclick="togglePassword()"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg id="icon-eye" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg id="icon-eye-off" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            {{-- Remember + Forgot --}}
                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="remember" id="remember_me"
                                           class="w-4 h-4 rounded border-gray-300 dark:border-gray-600"
                                           style="accent-color:#1a56db;">
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Ingat Saya</span>
                                </label>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-sm font-medium hover:underline"
                                   style="color:#1a56db;">
                                    Lupa Kata Laluan?
                                </a>
                                @endif
                            </div>

                            {{-- Submit button --}}
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 text-white text-sm font-semibold py-3 rounded-xl transition-all"
                                    style="background:linear-gradient(135deg,#1a56db,#3b82f6);box-shadow:0 4px 14px rgba(26,86,219,0.4);"
                                    onmouseover="this.style.opacity='0.92'"
                                    onmouseout="this.style.opacity='1'">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Masuk ke Akaun
                            </button>
                        </form>

                        {{-- Footer note --}}
                        <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-4">
                            Ada masalah?
                            <a href="{{ route('feedback.create') }}"
                               class="font-medium hover:underline" style="color:#1a56db;">
                                Hubungi pentadbir
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            {{-- ══ RIGHT: Announcements Card (3/5) ══ --}}
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden"
                     style="box-shadow:0 20px 60px rgba(0,0,0,0.12);">

                    {{-- Card header --}}
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg" style="background:#eff6ff;">
                                <svg class="w-4 h-4" style="color:#1a56db;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Papan Makluman Utama</h2>
                                <p class="text-xs text-gray-400">Hebahan terkini sistem APKM</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full"
                              style="background:#eff6ff;color:#1a56db;">
                            Info Terkini
                        </span>
                    </div>

                    {{-- Announcements list --}}
                    @php
                    $labelMap = [
                        'Ciri Baharu'     => ['bg'=>'#d1fae5','color'=>'#065f46','icon'=>'🆕'],
                        'Pembaikan'       => ['bg'=>'#cffafe','color'=>'#155e75','icon'=>'🔧'],
                        'Penyelenggaraan' => ['bg'=>'#fef9c3','color'=>'#713f12','icon'=>'⚠️'],
                        'Kritikal'        => ['bg'=>'#fee2e2','color'=>'#7f1d1d','icon'=>'🚨'],
                        'Pengumuman'      => ['bg'=>'#dbeafe','color'=>'#1e3a8a','icon'=>'📢'],
                    ];
                    @endphp

                    @forelse($announcements as $i => $ann)
                    @php
                        $lm = $labelMap[$ann->homepage_label] ?? ['bg'=>'#f3f4f6','color'=>'#374151','icon'=>'📢'];
                    @endphp

                    <div class="px-5 py-4 border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors {{ $loop->last ? 'border-b-0' : '' }}">
                        <div class="flex items-start gap-3">

                            {{-- Icon badge --}}
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                 style="background:{{ $lm['bg'] }};">
                                {{ $lm['icon'] }}
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                                          style="background:{{ $lm['bg'] }};color:{{ $lm['color'] }};">
                                        {{ $ann->homepage_label ?? 'Hebahan Umum' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $ann->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <button type="button" onclick="showAnnouncementModal({{ $ann->id }})"
                                        class="text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 text-left w-full leading-snug transition-colors line-clamp-1">
                                    {{ $ann->title }}
                                </button>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($ann->content), 100) }}
                                </p>
                                @if(strlen(strip_tags($ann->content)) > 100)
                                <button type="button" onclick="showAnnouncementModal({{ $ann->id }})"
                                        class="text-xs font-medium mt-1 hover:underline transition-colors"
                                        style="color:#1a56db;">
                                    Baca selanjutnya →
                                </button>
                                @endif
                            </div>
                        </div>

                        {{-- Hidden modal data --}}
                        <div id="announcement-data-{{ $ann->id }}" class="hidden"
                             data-title="{{ $ann->title }}"
                             data-author="{{ $ann->user->name }}"
                             data-is-admin="{{ $ann->user->hasRole('Super Admin') ? '1' : '0' }}"
                             data-date="{{ $ann->created_at->format('d/m/Y') }}"
                             data-label="{{ $ann->homepage_label }}"
                             data-view-count="{{ $ann->view_count }}"
                             data-readers-count="{{ $ann->authenticated_readers_count }}"
                             data-announcement-id="{{ $ann->id }}">
                            {!! $ann->content !!}
                        </div>
                    </div>

                    @empty
                    <div class="flex flex-col items-center justify-center py-14 text-center px-6">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                             style="background:#f0f9ff;">
                            <svg class="w-8 h-8" style="color:#93c5fd;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Tiada Hebahan Baharu</p>
                        <p class="text-xs text-gray-400 mt-1">Semak semula kemudian.</p>
                    </div>
                    @endforelse

                    {{-- Footer --}}
                    <div class="px-5 py-3" style="background:#f8faff;border-top:1px solid #e8f0fe;">
                        <p class="text-xs text-center" style="color:#6b90d4;">
                            🔒 Log masuk untuk melihat butiran penuh hebahan
                        </p>
                    </div>
                </div>
            </div>

        </div>{{-- end grid --}}

        {{-- ══ PRAYER TIMES WIDGET ══ --}}
        <div class="mt-5">
            <x-prayer-times-widget />
        </div>

        {{-- Footer credit --}}
        <p class="text-center text-xs text-gray-400 dark:text-gray-600 mt-6">
            © {{ date('Y') }} Jabatan Agama Islam Daerah Manjung &bull; APKM v2.0
        </p>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     ANNOUNCEMENT MODAL
═══════════════════════════════════════════════════════════ --}}
<div id="announcementModal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
     style="background:rgba(0,0,0,0.65);">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl flex flex-col"
         style="max-height:88vh;box-shadow:0 25px 80px rgba(0,0,0,0.3);">

        {{-- Modal header --}}
        <div class="p-5 flex-shrink-0 rounded-t-2xl"
             style="background:linear-gradient(135deg,#0f2460,#1a56db);">
            <div class="flex items-start justify-between mb-3">
                <span id="modalLabel"
                      class="px-3 py-1 text-xs font-bold rounded-full"
                      style="background:rgba(255,255,255,0.2);color:#fff;">📢 Pengumuman</span>
                <button type="button" onclick="closeAnnouncementModal()"
                        class="p-1 rounded-lg transition-colors"
                        style="color:rgba(255,255,255,0.7);"
                        onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                        onmouseout="this.style.background='transparent'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <h3 id="modalTitle" class="text-base font-bold text-white leading-snug mb-2"></h3>
            <div class="flex items-center gap-3 text-xs flex-wrap"
                 style="color:rgba(186,222,255,0.9);">
                <span id="modalAuthor"></span>
                <span id="modalAdminBadge" class="hidden px-2 py-0.5 font-semibold rounded-full"
                      style="background:rgba(255,255,255,0.2);">✓ Pentadbir</span>
                <span id="modalDate" style="color:rgba(186,222,255,0.65);"></span>
            </div>
        </div>

        {{-- Modal body --}}
        <div class="overflow-y-auto flex-1 p-6">
            <div id="modalBody"
                 class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
            </div>
        </div>

        {{-- Modal footer --}}
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex-shrink-0">
            <button type="button" onclick="closeAnnouncementModal()"
                    class="w-full flex items-center justify-center gap-2 text-white text-sm font-semibold py-2.5 rounded-xl transition-all"
                    style="background:linear-gradient(135deg,#1a56db,#3b82f6);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Faham, Tutup
            </button>
        </div>
    </div>
</div>

<script>
// ── Tab switcher ────────────────────────────────────────────────────────────
function switchLoginType(type) {
    var loginId    = document.getElementById('login_id');
    var loginLabel = document.getElementById('login_label');
    var loginType  = document.getElementById('login_type');
    var tabStaff   = document.getElementById('tab-staff');
    var tabParent  = document.getElementById('tab-parent');

    loginType.value = type;

    var activeStyle   = 'background:#fff;color:#1a56db;box-shadow:0 1px 4px rgba(0,0,0,0.15);';
    var inactiveStyle = 'color:rgba(255,255,255,0.85);background:transparent;box-shadow:none;';

    if (type === 'staff') {
        loginLabel.textContent  = 'Alamat Emel';
        loginId.type            = 'email';
        loginId.placeholder     = 'nama@sekolah.edu.my';
        tabStaff.style.cssText  = activeStyle;
        tabParent.style.cssText = inactiveStyle;
    } else {
        loginLabel.textContent  = 'No. Kad Pengenalan Ibu/Bapa';
        loginId.type            = 'text';
        loginId.placeholder     = '890101-10-5555';
        tabParent.style.cssText = activeStyle;
        tabStaff.style.cssText  = inactiveStyle;
    }
}

// ── Password toggle ─────────────────────────────────────────────────────────
function togglePassword() {
    var f = document.getElementById('password-field');
    var e = document.getElementById('icon-eye');
    var o = document.getElementById('icon-eye-off');
    f.type === 'password'
        ? (f.type = 'text',  e.classList.add('hidden'),    o.classList.remove('hidden'))
        : (f.type = 'password', e.classList.remove('hidden'), o.classList.add('hidden'));
}

// ── Announcement modal ──────────────────────────────────────────────────────
var labelIcons = { 'Ciri Baharu':'🆕','Pembaikan':'🔧','Penyelenggaraan':'⚠️','Kritikal':'🚨','Pengumuman':'📢' };

function showAnnouncementModal(id) {
    var d     = document.getElementById('announcement-data-' + id);
    var label = d.getAttribute('data-label');
    var annId = d.getAttribute('data-announcement-id');

    document.getElementById('modalTitle').textContent  = d.getAttribute('data-title');
    document.getElementById('modalBody').innerHTML     = d.innerHTML;
    document.getElementById('modalAuthor').textContent = '👤 ' + d.getAttribute('data-author');
    document.getElementById('modalDate').textContent   = '📅 ' + d.getAttribute('data-date');
    document.getElementById('modalLabel').textContent  = (labelIcons[label] || '📢') + ' ' + (label || 'Hebahan Umum');

    var badge = document.getElementById('modalAdminBadge');
    d.getAttribute('data-is-admin') === '1' ? badge.classList.remove('hidden') : badge.classList.add('hidden');

    document.getElementById('announcementModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    fetch('/announcements/' + annId + '/increment-view', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
}

function closeAnnouncementModal() {
    document.getElementById('announcementModal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.getElementById('announcementModal').addEventListener('click', function (e) {
    if (e.target === this) closeAnnouncementModal();
});

// ── Restore tab state on validation error ───────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    var t = document.getElementById('login_type').value;
    if (t === 'parent') switchLoginType('parent');
});
</script>
@endsection
