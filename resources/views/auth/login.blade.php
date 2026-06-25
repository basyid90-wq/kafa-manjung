@section('title', 'eKAFA — Sistem Pengurusan KAFA Digital')
@extends('layout-fb.auth')

@section('content')
<div x-data="{ loginType: '{{ old('login_type', 'staff') }}', showPassword: false, yearly: true, mobileMenu: false }" class="scroll-smooth">

    {{-- ════════════ 1. NAVBAR ════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-5">
            <div class="flex items-center justify-between h-16">
                <a href="#" class="text-xl font-extrabold text-gray-900 tracking-tight">eKAFA</a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#ciri-ciri" onclick="smoothScroll('#ciri-ciri')" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Ciri-ciri</a>
                    <a href="#harga" onclick="smoothScroll('#harga')" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Harga</a>
                    <a href="#log-masuk" onclick="smoothScroll('#log-masuk')" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Log Masuk</a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="https://wa.me/60194920559" target="_blank" rel="noopener"
                       class="hidden md:inline-flex bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                        Mula Sekarang
                    </a>
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-gray-600 hover:text-gray-900">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <div x-show="mobileMenu" x-transition class="md:hidden border-t border-gray-100 py-4 space-y-3">
                <a href="#ciri-ciri" onclick="smoothScroll('#ciri-ciri'); mobileMenu=false" class="block text-sm font-medium text-gray-600 hover:text-blue-600 py-1">Ciri-ciri</a>
                <a href="#harga" onclick="smoothScroll('#harga'); mobileMenu=false" class="block text-sm font-medium text-gray-600 hover:text-blue-600 py-1">Harga</a>
                <a href="#log-masuk" onclick="smoothScroll('#log-masuk'); mobileMenu=false" class="block text-sm font-medium text-gray-600 hover:text-blue-600 py-1">Log Masuk</a>
                <a href="https://wa.me/60194920559" target="_blank" rel="noopener"
                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg text-center transition-colors">
                    Mula Sekarang
                </a>
            </div>
        </div>
    </nav>

    {{-- ════════════ 2. HERO ════════════ --}}
    <section class="pt-24 pb-16 md:pt-32 md:pb-20 bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-700">
        <div class="max-w-4xl mx-auto px-5 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 text-blue-100 text-sm font-medium mb-6">
                🎓 Dipercayai Sekolah KAFA Seluruh Malaysia
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                Urus Sekolah KAFA Anda Lebih Mudah
            </h1>
            <p class="text-base md:text-lg text-blue-100/90 max-w-2xl mx-auto mb-8 leading-relaxed">
                Sistem pengurusan digital lengkap — guru, murid, kehadiran, peperiksaan dan lebih lagi dalam satu platform.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-10">
                <a href="https://wa.me/60194920559" target="_blank" rel="noopener"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-blue-700 font-semibold px-8 py-3 rounded-lg text-sm transition-colors shadow-lg shadow-black/10">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                    Hubungi Kami
                </a>
                <a href="#demo" onclick="smoothScroll('#demo')"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border-2 border-white/30 hover:border-white/50 text-white font-semibold px-8 py-3 rounded-lg text-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Lihat Demo
                </a>
            </div>
            <div class="max-w-3xl mx-auto">
                <div class="rounded-xl overflow-hidden shadow-2xl border border-gray-700 bg-gray-900 p-2">
                    <img src="/storage/frontend/dashboard.png"
                         onerror="this.src='{{ asset('template/perak.png') }}'"
                         alt="eKAFA Dashboard" class="rounded-lg w-full">
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════ 3. STATS ════════════ --}}
    <section class="relative -mt-10 pb-6">
        <div class="max-w-3xl mx-auto px-5">
            <div class="bg-white rounded-2xl shadow-lg grid grid-cols-3 divide-x divide-gray-100 overflow-hidden">
                <div class="px-4 py-6 text-center">
                    <div class="text-2xl md:text-3xl font-extrabold text-gray-900">100+</div>
                    <div class="text-xs md:text-sm text-gray-500 mt-1">Sekolah Berdaftar</div>
                </div>
                <div class="px-4 py-6 text-center">
                    <div class="text-2xl md:text-3xl font-extrabold text-gray-900">10,000+</div>
                    <div class="text-xs md:text-sm text-gray-500 mt-1">Murid Diuruskan</div>
                </div>
                <div class="px-4 py-6 text-center">
                    <div class="text-2xl md:text-3xl font-extrabold text-gray-900">99.9%</div>
                    <div class="text-xs md:text-sm text-gray-500 mt-1">Uptime Sistem</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════ 4. FEATURES ════════════ --}}
    <section id="ciri-ciri" class="py-16 md:py-20 bg-gray-50 scroll-mt-20">
        <div class="max-w-5xl mx-auto px-5">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3">Semua yang anda perlukan</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Modul lengkap untuk pengurusan KAFA — dari rekod murid hingga analitik prestasi.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-3">📊</div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1.5">Dashboard Guru</h3>
                    <p class="text-sm text-gray-500">Rumusan aktiviti, kehadiran dan prestasi pelajar dalam satu pandangan.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-3">✅</div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1.5">Rekod Kehadiran</h3>
                    <p class="text-sm text-gray-500">Imbasan QR pantas dan laporan kehadiran bulanan yang terperinci.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-3">📝</div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1.5">Peperiksaan & Keputusan</h3>
                    <p class="text-sm text-gray-500">Rekod markah, slip keputusan dan analisis prestasi peperiksaan.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-3">📅</div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1.5">Jadual Waktu & RPH</h3>
                    <p class="text-sm text-gray-500">Penjadualan kelas dan rancangan pengajaran harian yang tersusun.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-3">👨‍👧</div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1.5">Pengurusan Pelajar</h3>
                    <p class="text-sm text-gray-500">Profil lengkap, pendaftaran dan pemindahan kelas pelajar.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-3">📈</div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1.5">Laporan & Analitik</h3>
                    <p class="text-sm text-gray-500">Eksport data dan laporan komprehensif di pelbagai peringkat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════ 5. DEMO ════════════ --}}
    <section id="demo" class="py-16 md:py-20 bg-white scroll-mt-20">
        <div class="max-w-5xl mx-auto px-5">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3">Tengok sendiri bagaimana eKAFA berfungsi</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Dashboard yang intuitif dan mudah digunakan oleh semua peringkat pengguna.</p>
            </div>
            <div class="max-w-4xl mx-auto bg-gray-900 rounded-2xl p-2 shadow-2xl">
                <img src="/storage/frontend/dashboard.png"
                     onerror="this.src='{{ asset('template/perak.png') }}'"
                     alt="Demo eKAFA" class="rounded-xl w-full">
            </div>
        </div>
    </section>

    {{-- ════════════ 6. PRICING ════════════ --}}
    <section id="harga" class="py-16 md:py-20 bg-gray-50 scroll-mt-20">
        <div class="max-w-5xl mx-auto px-5">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3">Harga Mudah, Tiada Kejutan</h2>
                <p class="text-gray-500">Satu pelan. Semua modul. Tiada yuran tersembunyi.</p>
            </div>

            <div class="flex items-center justify-center gap-1 bg-gray-100 rounded-lg p-1 w-fit mx-auto mb-10">
                <button @click="yearly = false"
                        :class="!yearly ? 'bg-white shadow text-gray-900' : 'text-gray-500'"
                        class="px-5 py-2 rounded-md text-sm font-semibold transition-all">
                    Bulanan
                </button>
                <button @click="yearly = true"
                        :class="yearly ? 'bg-white shadow text-gray-900' : 'text-gray-500'"
                        class="px-5 py-2 rounded-md text-sm font-semibold transition-all">
                    Tahunan
                </button>
            </div>

            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-500 overflow-hidden">
                    <div class="bg-blue-600 text-white text-center py-2 text-xs font-bold uppercase tracking-wider">Paling Popular</div>
                    <div class="p-8 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">eKAFA Pro</h3>
                        <p class="text-sm text-gray-500 mb-6">Untuk sekolah KAFA yang serius</p>
                        <div class="mb-6">
                            <span class="text-4xl font-extrabold text-gray-900" x-text="yearly ? 'RM250' : 'RM25'"></span>
                            <span class="text-gray-500 text-sm">/</span>
                            <span class="text-gray-500 text-sm" x-text="yearly ? 'tahun' : 'bulan'"></span>
                        </div>
                        <div x-show="yearly" class="text-xs font-semibold text-green-600 bg-green-50 rounded-full px-3 py-1 inline-block mb-6">Jimat RM50!</div>
                        <ul class="space-y-3 text-left mb-8">
                            <li class="flex items-center gap-2.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Guru Tanpa Had
                            </li>
                            <li class="flex items-center gap-2.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Murid Tanpa Had
                            </li>
                            <li class="flex items-center gap-2.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Semua Modul Termasuk
                            </li>
                            <li class="flex items-center gap-2.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Sokongan WhatsApp
                            </li>
                            <li class="flex items-center gap-2.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Kemaskini Percuma
                            </li>
                            <li class="flex items-center gap-2.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Data Selamat & Disandar
                            </li>
                        </ul>
                        <a href="https://wa.me/60194920559" target="_blank" rel="noopener"
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg text-sm transition-colors">
                            Mulakan Percubaan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════ 7. CTA ════════════ --}}
    <section class="py-16 md:py-20 bg-gradient-to-br from-blue-600 to-indigo-700">
        <div class="max-w-3xl mx-auto px-5 text-center">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-4">Bersedia untuk digitalisasi sekolah anda?</h2>
            <p class="text-blue-100/80 mb-8 max-w-lg mx-auto">Sertai 100+ sekolah KAFA yang telah beralih ke sistem digital.</p>
            <a href="https://wa.me/60194920559" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-blue-700 font-semibold px-8 py-3.5 rounded-lg text-sm transition-colors shadow-lg shadow-black/10">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                Hubungi Kami Sekarang
            </a>
        </div>
    </section>

    {{-- ════════════ 8. LOGIN SECTION ════════════ --}}
    <section id="log-masuk" class="py-16 md:py-20 bg-white scroll-mt-20">
        <div class="max-w-md mx-auto px-5">
            <div class="text-center mb-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sudah menjadi pengguna?</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">Log Masuk ke Sistem</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
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

                <div class="p-6">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="login_type" x-model="loginType">

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
            @php
            $labelMap = [
                'Ciri Baharu'     => ['bg'=>'bg-emerald-50','text'=>'text-emerald-700','icon'=>'🆕'],
                'Pembaikan'       => ['bg'=>'bg-cyan-50','text'=>'text-cyan-700','icon'=>'🔧'],
                'Penyelenggaraan' => ['bg'=>'bg-amber-50','text'=>'text-amber-700','icon'=>'⚠️'],
                'Kritikal'        => ['bg'=>'bg-red-50','text'=>'text-red-700','icon'=>'🚨'],
                'Pengumuman'      => ['bg'=>'bg-blue-50','text'=>'text-blue-700','icon'=>'📢'],
            ];
            @endphp
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-6">
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
                                <p class="text-sm text-gray-500 mt-1 truncate">{{ strip_tags($ann->content) }}</p>
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

    {{-- ════════════ 9. FOOTER ════════════ --}}
    <footer class="bg-gray-900 py-12">
        <div class="max-w-5xl mx-auto px-5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <div class="text-xl font-extrabold text-white tracking-tight mb-1">eKAFA</div>
                    <p class="text-sm text-gray-400">Sistem Pengurusan KAFA Digital</p>
                </div>
                <div class="flex items-center gap-6">
                    <a href="#ciri-ciri" onclick="smoothScroll('#ciri-ciri')" class="text-sm text-gray-400 hover:text-white transition-colors">Ciri-ciri</a>
                    <a href="#harga" onclick="smoothScroll('#harga')" class="text-sm text-gray-400 hover:text-white transition-colors">Harga</a>
                    <a href="https://wa.me/60194920559" target="_blank" rel="noopener" class="text-sm text-gray-400 hover:text-white transition-colors">Hubungi Kami</a>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center">
                <p class="text-xs text-gray-500">&copy; 2026 eKAFA &middot; Hak Cipta Terpelihara</p>
            </div>
        </div>
    </footer>

    {{-- ════════════ MODAL ════════════ --}}
    <div id="announcementModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-black/70">
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

    {{-- ════════════ SCRIPTS ════════════ --}}
    <script>
    function smoothScroll(selector) {
        var el = document.querySelector(selector);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    var labelIcons = { 'Ciri Baharu':'🆕','Pembaikan':'🔧','Penyelenggaraan':'⚠️','Kritikal':'🚨','Pengumuman':'📢' };

    function showAnnouncementModal(id) {
        var d = document.getElementById('announcement-data-' + id);
        if (!d) return;
        var label = d.getAttribute('data-label');
        var annId = d.getAttribute('data-announcement-id');
        document.getElementById('modalTitle').textContent  = d.getAttribute('data-title');
        document.getElementById('modalBody').innerHTML     = d.innerHTML;
        document.getElementById('modalAuthor').textContent = '\uD83D\uDC64 ' + d.getAttribute('data-author');
        document.getElementById('modalDate').textContent   = '\uD83D\uDCC5 ' + d.getAttribute('data-date');
        document.getElementById('modalLabel').textContent  = (labelIcons[label] || '\uD83D\uDCE2') + ' ' + (label || 'Hebahan Umum');
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

    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('announcementModal');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeAnnouncementModal();
            });
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                var m = document.getElementById('announcementModal');
                if (m && !m.classList.contains('hidden')) closeAnnouncementModal();
            }
        });
    });
    </script>

</div>
@endsection
