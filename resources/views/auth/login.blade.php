@section('title', 'Log Masuk')
@extends('layout-fb.auth')

@section('content')

<style>
    @media (max-width: 767px) {
        .login-grid { grid-template-columns: 1fr !important; }
        .ann-panel   { max-height: none !important; }
    }
</style>

{{-- ══════════════════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════════════════ --}}
<div style="background:linear-gradient(135deg,#0c1a4f 0%,#1a56db 55%,#3b82f6 100%);
            position:relative;overflow:hidden;">

    <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none;">
        <div style="position:absolute;top:-80px;right:-80px;width:380px;height:380px;
                    background:rgba(255,255,255,0.05);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;
                    background:rgba(255,255,255,0.04);border-radius:50%;"></div>
        <div style="position:absolute;top:50%;left:30%;width:180px;height:180px;
                    background:rgba(255,255,255,0.025);border-radius:50%;transform:translateY(-50%);"></div>
    </div>

    <div style="position:relative;max-width:72rem;margin:0 auto;
                padding:2.5rem 1.5rem 2.75rem;text-align:center;">

        <div style="display:flex;justify-content:center;margin-bottom:1.25rem;">
            <div style="padding:0.875rem;border-radius:1.25rem;background:#ffffff;
                        box-shadow:0 4px 20px rgba(0,0,0,0.2);">
                <img src="{{ asset('template/perak.png') }}" alt="Logo APKM"
                     style="height:64px;width:auto;">
            </div>
        </div>

        <div style="display:inline-flex;align-items:center;gap:6px;
                    padding:5px 14px;border-radius:999px;
                    background:rgba(255,255,255,0.15);
                    color:rgba(219,234,254,0.95);
                    font-size:0.75rem;font-weight:600;
                    margin-bottom:1rem;letter-spacing:0.03em;">
            <span style="width:7px;height:7px;background:#4ade80;border-radius:50%;
                         display:inline-block;box-shadow:0 0 6px #4ade80;"></span>
            Sistem KAFA &mdash; Daerah Manjung, Perak
        </div>

        <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;color:#ffffff;
                   letter-spacing:-0.03em;line-height:1.1;margin-bottom:0.75rem;">
            Aplikasi Pengurusan<br>
            <span style="color:#93c5fd;">KAFA Manjung</span>
        </h1>

        <p style="font-size:1rem;font-weight:400;color:rgba(186,222,255,0.88);
                  max-width:520px;margin:0 auto;line-height:1.6;">
            Sistem bersepadu untuk pentadbir, guru, dan ibu bapa —<br>
            dibangunkan khas untuk daerah Manjung, Perak.
        </p>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MAIN CONTENT — 2-column grid
═══════════════════════════════════════════════════════════ --}}
<div style="background:#f1f5f9;min-height:60vh;">
    <div style="max-width:1200px;margin:0 auto;padding:2rem 1.25rem 3rem;">

        <div class="login-grid"
             style="display:grid;grid-template-columns:minmax(0,5fr) minmax(0,7fr);
                    gap:1.5rem;align-items:start;">

            {{-- ════ LEFT — Login Card ════ --}}
            <div style="background:#fff;border-radius:1.25rem;overflow:hidden;
                        box-shadow:0 20px 60px rgba(0,0,0,0.13);">

                {{-- Tabs --}}
                <div style="border-bottom:1px solid #e5e7eb;">
                    <div style="display:flex;">
                        <button id="tab-staff" type="button" onclick="switchLoginType('staff')"
                                style="flex:1;display:flex;align-items:center;justify-content:center;gap:8px;
                                       padding:1rem;font-size:0.9rem;font-weight:600;
                                       border:none;background:none;cursor:pointer;
                                       color:#1a56db;border-bottom:2px solid #1a56db;margin-bottom:-1px;">
                            <svg style="width:17px;height:17px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Kakitangan
                        </button>
                        <button id="tab-parent" type="button" onclick="switchLoginType('parent')"
                                style="flex:1;display:flex;align-items:center;justify-content:center;gap:8px;
                                       padding:1rem;font-size:0.9rem;font-weight:500;
                                       border:none;background:none;cursor:pointer;
                                       color:#6b7280;border-bottom:2px solid transparent;margin-bottom:-1px;">
                            <svg style="width:17px;height:17px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Ibu Bapa
                        </button>
                    </div>
                </div>

                {{-- Form --}}
                <div style="padding:1.5rem;">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}"
                          style="display:flex;flex-direction:column;gap:1rem;">
                        @csrf
                        <input type="hidden" name="login_type" id="login_type"
                               value="{{ old('login_type', 'staff') }}">

                        {{-- Login ID --}}
                        <div>
                            <label for="login_id" id="login_label"
                                   style="display:block;font-size:0.7rem;font-weight:700;color:#6b7280;
                                          text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px;">
                                {{ old('login_type') === 'parent' ? 'No. Kad Pengenalan Ibu/Bapa' : 'Emel / No. IC / Nama Pengguna' }}
                            </label>
                            <input type="text" id="login_id" name="login_id"
                                   value="{{ old('login_id') }}" required autofocus
                                   placeholder="{{ old('login_type') === 'parent' ? '890101-10-5555' : 'emel / no. ic / username' }}"
                                   style="width:100%;font-size:0.875rem;border-radius:0.75rem;
                                          border:1px solid {{ $errors->has('login_id') ? '#f87171' : '#e5e7eb' }};
                                          background:#f9fafb;padding:0.625rem 0.875rem;
                                          outline:none;box-sizing:border-box;">
                            @error('login_id')
                            <p style="margin-top:4px;font-size:0.75rem;color:#ef4444;">⚠ {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password-field"
                                   style="display:block;font-size:0.7rem;font-weight:700;color:#6b7280;
                                          text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px;">
                                Kata Laluan
                            </label>
                            <div style="position:relative;">
                                <input type="password" id="password-field" name="password"
                                       required placeholder="••••••••••"
                                       style="width:100%;font-size:0.875rem;border-radius:0.75rem;
                                              border:1px solid {{ $errors->has('password') ? '#f87171' : '#e5e7eb' }};
                                              background:#f9fafb;padding:0.625rem 2.5rem 0.625rem 0.875rem;
                                              outline:none;box-sizing:border-box;">
                                <button type="button" onclick="togglePassword()"
                                        style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);
                                               border:none;background:none;cursor:pointer;color:#9ca3af;padding:2px;">
                                    <svg id="icon-eye" style="width:16px;height:16px;display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="icon-eye-off" style="width:16px;height:16px;display:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p style="margin-top:4px;font-size:0.75rem;color:#ef4444;">⚠ {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember + Forgot --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input type="checkbox" name="remember" id="remember_me"
                                       style="width:15px;height:15px;accent-color:#1a56db;cursor:pointer;">
                                <span style="font-size:0.875rem;color:#4b5563;">Ingat Saya</span>
                            </label>
                            <a href="https://wa.me/60194920559?text=Saya%20perlu%20bantuan%20log%20masuk%20APKM"
                               target="_blank" rel="noopener"
                               style="font-size:0.875rem;font-weight:600;color:#25d366;
                                      text-decoration:none;display:flex;align-items:center;gap:5px;">
                                <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Lupa Kata Laluan?
                            </a>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                style="width:100%;display:flex;align-items:center;justify-content:center;
                                       gap:8px;color:#fff;font-size:0.875rem;font-weight:600;
                                       padding:0.75rem;border-radius:0.75rem;border:none;cursor:pointer;
                                       background:linear-gradient(135deg,#1a56db,#3b82f6);
                                       box-shadow:0 4px 14px rgba(26,86,219,0.4);"
                                onmouseover="this.style.opacity='0.9'"
                                onmouseout="this.style.opacity='1'">
                            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Masuk ke Akaun
                        </button>
                    </form>

                    <p style="text-align:center;font-size:0.8rem;color:#9ca3af;margin-top:1rem;">
                        Ada masalah?
                        <a href="https://wa.me/60194920559?text=Saya%20perlu%20bantuan%20log%20masuk%20APKM"
                           target="_blank" rel="noopener"
                           style="font-weight:600;color:#25d366;text-decoration:none;
                                  display:inline-flex;align-items:center;gap:4px;">
                            <svg style="width:13px;height:13px;" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Hubungi pentadbir
                        </a>
                    </p>
                </div>
            </div>{{-- end login card --}}

            {{-- ════ RIGHT — Announcements Card ════ --}}
            <div style="background:#fff;border-radius:1.25rem;overflow:hidden;
                        box-shadow:0 8px 32px rgba(0,0,0,0.10);">

                {{-- Card header --}}
                <div style="padding:1rem 1.25rem;border-bottom:1px solid #f3f4f6;
                            display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:0.75rem;">
                        <div style="padding:0.5rem;border-radius:0.5rem;background:#eff6ff;flex-shrink:0;">
                            <svg style="width:16px;height:16px;color:#1a56db;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 style="font-size:1rem;font-weight:700;color:#111827;margin:0;">Papan Makluman Utama</h2>
                            <p style="font-size:0.8rem;color:#9ca3af;margin:0;">Hebahan terkini sistem APKM</p>
                        </div>
                    </div>
                    <span style="padding:5px 12px;font-size:0.78rem;font-weight:700;border-radius:999px;
                                 background:#eff6ff;color:#1a56db;">
                        Info Terkini
                    </span>
                </div>

                {{-- Scrollable announcement list --}}
                <div class="ann-panel" style="max-height:420px;overflow-y:auto;">
                    @php
                    $labelMap = [
                        'Ciri Baharu'     => ['bg'=>'#d1fae5','color'=>'#065f46','icon'=>'🆕'],
                        'Pembaikan'       => ['bg'=>'#cffafe','color'=>'#155e75','icon'=>'🔧'],
                        'Penyelenggaraan' => ['bg'=>'#fef9c3','color'=>'#713f12','icon'=>'⚠️'],
                        'Kritikal'        => ['bg'=>'#fee2e2','color'=>'#7f1d1d','icon'=>'🚨'],
                        'Pengumuman'      => ['bg'=>'#dbeafe','color'=>'#1e3a8a','icon'=>'📢'],
                    ];
                    @endphp

                    @forelse($announcements as $ann)
                    @php $lm = $labelMap[$ann->homepage_label] ?? ['bg'=>'#f3f4f6','color'=>'#374151','icon'=>'📢']; @endphp

                    <div style="padding:1rem 1.25rem;border-bottom:{{ $loop->last ? 'none' : '1px solid #f9fafb' }};">
                        <div style="display:flex;align-items:flex-start;gap:0.75rem;">

                            <div style="flex-shrink:0;width:40px;height:40px;border-radius:0.75rem;
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:1.125rem;background:{{ $lm['bg'] }};">
                                {{ $lm['icon'] }}
                            </div>

                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;margin-bottom:6px;">
                                    <span style="font-size:0.78rem;font-weight:700;padding:3px 10px;border-radius:999px;
                                                 background:{{ $lm['bg'] }};color:{{ $lm['color'] }};">
                                        {{ $ann->homepage_label ?? 'Hebahan Umum' }}
                                    </span>
                                    <span style="font-size:0.78rem;color:#9ca3af;">
                                        {{ $ann->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <button type="button" onclick="showAnnouncementModal({{ $ann->id }})"
                                        style="font-size:1rem;font-weight:700;color:#111827;border:none;
                                               background:none;cursor:pointer;text-align:left;width:100%;
                                               line-height:1.4;padding:0;display:-webkit-box;
                                               -webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $ann->title }}
                                </button>
                                <p style="font-size:0.85rem;color:#6b7280;margin:5px 0 0;
                                          display:-webkit-box;-webkit-line-clamp:2;
                                          -webkit-box-orient:vertical;overflow:hidden;line-height:1.5;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($ann->content), 120) }}
                                </p>
                                @if(strlen(strip_tags($ann->content)) > 120)
                                <button type="button" onclick="showAnnouncementModal({{ $ann->id }})"
                                        style="font-size:0.82rem;font-weight:600;color:#1a56db;border:none;
                                               background:none;cursor:pointer;padding:5px 0 0;">
                                    Baca selanjutnya →
                                </button>
                                @endif
                            </div>
                        </div>

                        <div id="announcement-data-{{ $ann->id }}" style="display:none;"
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
                    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;
                                padding:3.5rem 1.5rem;text-align:center;">
                        <div style="width:56px;height:56px;border-radius:1rem;
                                    display:flex;align-items:center;justify-content:center;
                                    background:#f0f9ff;margin-bottom:1rem;">
                            <svg style="width:28px;height:28px;color:#93c5fd;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <p style="font-size:0.875rem;font-weight:600;color:#6b7280;margin:0;">Tiada Hebahan Baharu</p>
                        <p style="font-size:0.75rem;color:#9ca3af;margin:4px 0 0;">Semak semula kemudian.</p>
                    </div>
                    @endforelse
                </div>{{-- end scrollable list --}}

                {{-- Footer --}}
                <div style="padding:0.75rem 1.25rem;background:#f8faff;border-top:1px solid #e8f0fe;">
                    <p style="font-size:0.75rem;text-align:center;color:#6b90d4;margin:0;">
                        🔒 Log masuk untuk melihat butiran penuh hebahan
                    </p>
                </div>
            </div>{{-- end announcements card --}}

        </div>{{-- end grid --}}

        <p style="text-align:center;font-size:0.78rem;color:#9ca3af;margin-top:1.5rem;">
            &copy; 2026 Pengurusan KAFA Daerah &bull; v1.0
        </p>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     ANNOUNCEMENT MODAL
═══════════════════════════════════════════════════════════ --}}
<div id="announcementModal"
     style="display:none;position:fixed;inset:0;z-index:50;
            background:rgba(0,0,0,0.65);
            align-items:center;justify-content:center;padding:1rem;">

    <div style="background:#fff;border-radius:1.25rem;width:100%;max-width:640px;
                display:flex;flex-direction:column;max-height:88vh;
                box-shadow:0 25px 80px rgba(0,0,0,0.3);">

        <div style="padding:1.25rem;flex-shrink:0;border-radius:1.25rem 1.25rem 0 0;
                    background:linear-gradient(135deg,#0f2460,#1a56db);">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:0.75rem;">
                <span id="modalLabel"
                      style="padding:3px 12px;font-size:0.72rem;font-weight:700;border-radius:999px;
                             background:rgba(255,255,255,0.2);color:#fff;">📢 Pengumuman</span>
                <button type="button" onclick="closeAnnouncementModal()"
                        style="padding:4px;border-radius:6px;border:none;cursor:pointer;
                               background:transparent;color:rgba(255,255,255,0.75);"
                        onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                        onmouseout="this.style.background='transparent'">
                    <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <h3 id="modalTitle" style="font-size:1rem;font-weight:700;color:#fff;
                                       line-height:1.35;margin:0 0 0.5rem;"></h3>
            <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;
                        font-size:0.72rem;color:rgba(186,222,255,0.9);">
                <span id="modalAuthor"></span>
                <span id="modalAdminBadge" style="display:none;padding:2px 8px;font-weight:700;
                      border-radius:999px;background:rgba(255,255,255,0.2);">✓ Pentadbir</span>
                <span id="modalDate" style="color:rgba(186,222,255,0.65);"></span>
            </div>
        </div>

        <div style="overflow-y:auto;flex:1;padding:1.5rem;">
            <div id="modalBody" style="font-size:0.875rem;color:#374151;line-height:1.7;white-space:pre-line;"></div>
        </div>

        <div style="padding:1rem 1.5rem;border-top:1px solid #f3f4f6;flex-shrink:0;">
            <button type="button" onclick="closeAnnouncementModal()"
                    style="width:100%;display:flex;align-items:center;justify-content:center;gap:8px;
                           color:#fff;font-size:0.875rem;font-weight:600;padding:0.625rem;
                           border-radius:0.75rem;border:none;cursor:pointer;
                           background:linear-gradient(135deg,#1a56db,#3b82f6);">
                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Faham, Tutup
            </button>
        </div>
    </div>
</div>

<script>
var TAB_ACTIVE   = 'flex:1;display:flex;align-items:center;justify-content:center;gap:8px;' +
                   'padding:1rem;font-size:0.9rem;font-weight:600;border:none;background:none;cursor:pointer;' +
                   'color:#1a56db;border-bottom:2px solid #1a56db;margin-bottom:-1px;';
var TAB_INACTIVE = 'flex:1;display:flex;align-items:center;justify-content:center;gap:8px;' +
                   'padding:1rem;font-size:0.9rem;font-weight:500;border:none;background:none;cursor:pointer;' +
                   'color:#6b7280;border-bottom:2px solid transparent;margin-bottom:-1px;';

function switchLoginType(type) {
    var loginId    = document.getElementById('login_id');
    var loginLabel = document.getElementById('login_label');
    var loginType  = document.getElementById('login_type');
    var tabStaff   = document.getElementById('tab-staff');
    var tabParent  = document.getElementById('tab-parent');
    loginType.value = type;
    if (type === 'staff') {
        loginLabel.textContent  = 'Emel / No. IC / Nama Pengguna';
        loginId.placeholder     = 'emel / no. ic / username';
        tabStaff.style.cssText  = TAB_ACTIVE;
        tabParent.style.cssText = TAB_INACTIVE;
    } else {
        loginLabel.textContent  = 'No. Kad Pengenalan Ibu/Bapa';
        loginId.placeholder     = '890101-10-5555';
        tabParent.style.cssText = TAB_ACTIVE;
        tabStaff.style.cssText  = TAB_INACTIVE;
    }
}

function togglePassword() {
    var f = document.getElementById('password-field');
    var e = document.getElementById('icon-eye');
    var o = document.getElementById('icon-eye-off');
    if (f.type === 'password') {
        f.type = 'text'; e.style.display = 'none'; o.style.display = 'block';
    } else {
        f.type = 'password'; e.style.display = 'block'; o.style.display = 'none';
    }
}

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
    badge.style.display = d.getAttribute('data-is-admin') === '1' ? 'inline' : 'none';
    var modal = document.getElementById('announcementModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    fetch('/announcements/' + annId + '/increment-view', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
}

function closeAnnouncementModal() {
    document.getElementById('announcementModal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('announcementModal').addEventListener('click', function (e) {
    if (e.target === this) closeAnnouncementModal();
});

document.addEventListener('DOMContentLoaded', function () {
    var t = document.getElementById('login_type').value;
    if (t === 'parent') switchLoginType('parent');
});
</script>
@endsection
