@section('title', 'Log Masuk')
@extends('layout-fb.auth')

@section('content')
<div x-data="{ loginType: '{{ old('login_type', 'staff') }}', showPassword: false }">

    {{-- HERO SECTION --}}
    <section class="bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600">
        <div class="max-w-5xl mx-auto px-5 py-14 md:py-20 text-center">
            <div class="flex justify-center mb-5">
                <div class="bg-white rounded-2xl p-3.5 shadow-lg">
                    <img src="{{ asset('template/perak.png') }}" alt="Logo APKM" class="h-16 md:h-20 w-auto">
                </div>
            </div>
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/20 text-blue-100 text-xs font-semibold tracking-wide mb-4">
                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                Sistem KAFA &mdash; Daerah Manjung, Perak
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                Aplikasi Pengurusan KAFA Manjung
            </h1>
            <p class="text-base md:text-lg text-blue-100 max-w-lg mx-auto">
                Sistem bersepadu untuk pentadbir, guru, dan ibu bapa
            </p>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section class="bg-gray-50 py-14 md:py-16">
        <div class="max-w-5xl mx-auto px-5">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 text-center mb-2">Segala-galanya dalam satu platform</h2>
            <p class="text-gray-500 text-center mb-10 max-w-md mx-auto">APKM menyediakan modul lengkap untuk pengurusan pendidikan KAFA</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                {{-- 1 --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1.5">Dashboard Guru</h3>
                    <p class="text-sm text-gray-500">Rumusan aktiviti, kehadiran, dan prestasi pelajar dalam satu pandangan.</p>
                </div>
                {{-- 2 --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1.5">Rekod Kehadiran</h3>
                    <p class="text-sm text-gray-500">Imbasan QR pantas dan laporan kehadiran bulanan yang terperinci.</p>
                </div>
                {{-- 3 --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1.5">Peperiksaan & Keputusan</h3>
                    <p class="text-sm text-gray-500">Rekod markah, slip keputusan, dan analisis prestasi peperiksaan pelajar.</p>
                </div>
                {{-- 4 --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1.5">Jadual Waktu & RPH</h3>
                    <p class="text-sm text-gray-500">Penjadualan kelas dan rancangan pengajaran harian yang tersusun.</p>
                </div>
                {{-- 5 --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1.5">Pengurusan Pelajar</h3>
                    <p class="text-sm text-gray-500">Pendaftaran, profil, pemindahan kelas, dan rekod pencapaian pelajar.</p>
                </div>
                {{-- 6 --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1.5">Laporan & Analitik</h3>
                    <p class="text-sm text-gray-500">Laporan komprehensif dan eksport data untuk analisis di pelbagai peringkat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- LOGIN SECTION --}}
    <section class="bg-gray-100 py-14 md:py-16">
        <div class="max-w-md mx-auto px-5">

            {{-- Login Card --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

                {{-- Tabs --}}
                <div class="flex border-b border-gray-100">
                    <button type="button" @click="loginType='staff'"
                            :class="loginType === 'staff' ? 'text-blue-600 border-blue-600 font-semibold' : 'text-gray-400 border-transparent font-medium'"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3.5 text-sm border-b-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Kakitangan
                    </button>
                    <button type="button" @click="loginType='parent'"
                            :class="loginType === 'parent' ? 'text-blue-600 border-blue-600 font-semibold' : 'text-gray-400 border-transparent font-medium'"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3.5 text-sm border-b-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Ibu Bapa
                    </button>
                </div>

                {{-- Form --}}
                <div class="p-6">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="login_type" x-model="loginType">

                        {{-- Login ID --}}
                        <div>
                            <label for="login_id"
                                   class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5"
                                   x-text="loginType === 'parent' ? 'No. Kad Pengenalan Ibu/Bapa' : 'Emel / No. IC / Nama Pengguna'">
                            </label>
                            <input type="text" id="login_id" name="login_id"
                                   value="{{ old('login_id') }}" required autofocus
                                   :placeholder="loginType === 'parent' ? '890101-10-5555' : 'contoh@email.com / 900101-01-5555 / username'"
                                   class="w-full text-sm rounded-lg border px-3.5 py-2.5 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                                          {{ $errors->has('login_id') ? 'border-red-300' : 'border-gray-200' }}">
                            @error('login_id')
                            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password-field"
                                   class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                                Kata Laluan
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'"
                                       id="password-field" name="password"
                                       required placeholder="••••••••••"
                                       class="w-full text-sm rounded-lg border px-3.5 py-2.5 pr-10 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition
                                              {{ $errors->has('password') ? 'border-red-300' : 'border-gray-200' }}">
                                <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember + Help --}}
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" id="remember_me"
                                       class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-600">Ingat Saya</span>
                            </label>
                            <a href="https://wa.me/60194920559?text=Saya%20perlu%20bantuan%20log%20masuk%20APKM"
                               target="_blank" rel="noopener"
                               class="text-sm font-semibold text-green-600 hover:text-green-700 inline-flex items-center gap-1">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                                Lupa Kata Laluan?
                            </a>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            Masuk ke Akaun
                        </button>
                    </form>

                    <p class="text-center text-xs text-gray-400 mt-5">
                        Ada masalah?
                        <a href="https://wa.me/60194920559?text=Saya%20perlu%20bantuan%20log%20masuk%20APKM"
                           target="_blank" rel="noopener"
                           class="font-semibold text-green-600 hover:text-green-700 inline-flex items-center gap-1">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                            Hubungi pentadbir
                        </a>
                    </p>
                </div>
            </div>

            {{-- Announcements Panel --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-blue-50">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-gray-900">Papan Makluman</h2>
                            <p class="text-xs text-gray-400">Hebahan terkini sistem APKM</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-600">Info Terkini</span>
                </div>

                <div class="max-h-96 overflow-y-auto divide-y divide-gray-50">
                    @php
                    $labelMap = [
                        'Ciri Baharu'     => ['bg'=>'bg-emerald-50','text'=>'text-emerald-700','icon'=>'🆕'],
                        'Pembaikan'       => ['bg'=>'bg-cyan-50','text'=>'text-cyan-700','icon'=>'🔧'],
                        'Penyelenggaraan' => ['bg'=>'bg-amber-50','text'=>'text-amber-700','icon'=>'⚠️'],
                        'Kritikal'        => ['bg'=>'bg-red-50','text'=>'text-red-700','icon'=>'🚨'],
                        'Pengumuman'      => ['bg'=>'bg-blue-50','text'=>'text-blue-700','icon'=>'📢'],
                    ];
                    @endphp

                    @forelse($announcements as $ann)
                    @php $lm = $labelMap[$ann->homepage_label] ?? ['bg'=>'bg-gray-50','text'=>'text-gray-600','icon'=>'📢']; @endphp

                    <div class="px-5 py-4">
                        <div class="flex items-start gap-3">
                            <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg {{ $lm['bg'] }}">
                                {{ $lm['icon'] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1.5">
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $lm['bg'] }} {{ $lm['text'] }}">
                                        {{ $ann->homepage_label ?? 'Hebahan Umum' }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $ann->created_at->format('d M Y') }}</span>
                                </div>
                                <button type="button" onclick="showAnnouncementModal({{ $ann->id }})"
                                        class="text-sm font-bold text-gray-900 text-left w-full hover:text-blue-600 transition-colors truncate leading-snug">
                                    {{ $ann->title }}
                                </button>
                                <p class="text-sm text-gray-500 mt-1 truncate">
                                    {{ strip_tags($ann->content) }}
                                </p>
                            </div>
                        </div>
                        <div id="announcement-data-{{ $ann->id }}" class="hidden"
                             data-title="{{ $ann->title }}"
                             data-author="{{ $ann->user->name }}"
                             data-is-admin="{{ $ann->user->hasRole('Super Admin') ? '1' : '0' }}"
                             data-date="{{ $ann->created_at->format('d/m/Y') }}"
                             data-label="{{ $ann->homepage_label }}"
                             data-announcement-id="{{ $ann->id }}">
                            {!! $ann->content !!}
                        </div>
                    </div>

                    @empty
                    <div class="flex flex-col items-center justify-center py-12 px-5 text-center">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-blue-50 mb-3">
                            <svg class="w-7 h-7 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-400">Tiada Hebahan Baharu</p>
                        <p class="text-xs text-gray-300 mt-1">Semak semula kemudian.</p>
                    </div>
                    @endforelse
                </div>

                <div class="px-5 py-3 bg-blue-50/50 border-t border-blue-100/50 text-center">
                    <p class="text-xs text-blue-500/70">Log masuk untuk melihat butiran penuh hebahan</p>
                </div>
            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-gray-100 py-6">
        <div class="max-w-5xl mx-auto px-5 text-center">
            <p class="text-xs text-gray-400">&copy; 2026 Pengurusan KAFA Daerah &bull; v1.0</p>
        </div>
    </footer>

</div>

{{-- ANNOUNCEMENT MODAL --}}
<div id="announcementModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70">

    <div class="bg-white rounded-2xl w-full max-w-xl flex flex-col max-h-[88vh] shadow-2xl">

        <div class="shrink-0 rounded-t-2xl bg-gradient-to-r from-blue-900 to-blue-600 px-5 py-4">
            <div class="flex items-start justify-between mb-2">
                <span id="modalLabel" class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-full bg-white/20 text-white">📢 Pengumuman</span>
                <button type="button" onclick="closeAnnouncementModal()" class="p-1 rounded-md text-white/70 hover:text-white hover:bg-white/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <h3 id="modalTitle" class="text-sm font-bold text-white leading-snug mb-1.5"></h3>
            <div class="flex items-center gap-3 flex-wrap text-xs text-blue-200/80">
                <span id="modalAuthor"></span>
                <span id="modalAdminBadge" class="hidden px-2 py-0.5 font-bold rounded-full bg-white/20">✓ Pentadbir</span>
                <span id="modalDate" class="text-blue-200/60"></span>
            </div>
        </div>

        <div class="overflow-y-auto flex-1 px-5 py-4">
            <div id="modalBody" class="text-sm text-gray-700 leading-relaxed whitespace-pre-line"></div>
        </div>

        <div class="shrink-0 px-5 py-3 border-t border-gray-100">
            <button type="button" onclick="closeAnnouncementModal()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200">
                Faham, Tutup
            </button>
        </div>
    </div>
</div>

<script>
var labelIcons = { 'Ciri Baharu':'🆕','Pembaikan':'🔧','Penyelenggaraan':'⚠️','Kritikal':'🚨','Pengumuman':'📢' };

function showAnnouncementModal(id) {
    var d = document.getElementById('announcement-data-' + id);
    if (!d) return;
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
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    fetch('/announcements/' + annId + '/increment-view', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
}

function closeAnnouncementModal() {
    var modal = document.getElementById('announcementModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('announcementModal').addEventListener('click', function (e) {
    if (e.target === this) closeAnnouncementModal();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        var modal = document.getElementById('announcementModal');
        if (modal && !modal.classList.contains('hidden')) closeAnnouncementModal();
    }
});
</script>
@endsection
