<!DOCTYPE html>
<html lang="ms" class="h-full dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'APKM') | Sistem KAFA Perak</title>
    <link rel="shortcut icon" href="{{ asset('template/perak.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-full" x-data="{ sidebarOpen: false }">

    {{-- ── Top Navbar ── --}}
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    {{-- Mobile sidebar toggle --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"/></svg>
                    </button>
                    {{-- Logo --}}
                    <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24 items-center gap-2">
                        <img src="{{ asset('template/perak.png') }}" class="h-8" alt="Logo">
                        <span class="self-center text-sm font-semibold whitespace-nowrap dark:text-white leading-tight">
                            APKM<br><span class="text-xs font-normal text-gray-500 dark:text-gray-300">Sistem KAFA Perak</span>
                        </span>
                    </a>
                </div>
                {{-- Right side --}}
                <div class="flex items-center gap-1">

                    @php
                        $unreadCount       = auth()->user()->unreadNotifications()->count();
                        $recentNotifs      = auth()->user()->unreadNotifications()->latest()->take(5)->get();
                    @endphp

                    {{-- ── Bell Notification ── --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="relative p-2 text-gray-500 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none"
                                title="Pemberitahuan">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($unreadCount > 0)
                            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </button>

                        {{-- Notification Dropdown --}}
                        <div x-show="open" x-transition
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-700 z-50"
                             style="display:none;">

                            {{-- Header --}}
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                <h6 class="text-sm font-semibold text-gray-900 dark:text-white">Pemberitahuan</h6>
                                @if($unreadCount > 0)
                                <form method="POST" action="{{ route('notifications.markRead') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-blue-600 hover:underline dark:text-blue-400">
                                        Tandakan semua dibaca
                                    </button>
                                </form>
                                @endif
                            </div>

                            {{-- List --}}
                            <div class="max-h-72 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-700">
                                @forelse($recentNotifs as $notif)
                                <a href="{{ route('notifications.read', $notif->id) }}"
                                   class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-900 dark:text-white leading-snug line-clamp-2">
                                            {{ $notif->data['title'] ?? $notif->data['message'] ?? 'Pemberitahuan baharu' }}
                                        </p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $notif->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="flex-shrink-0 w-2 h-2 mt-1 rounded-full bg-blue-500"></span>
                                </a>
                                @empty
                                <div class="px-4 py-6 text-center">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Tiada pemberitahuan baharu</p>
                                </div>
                                @endforelse
                            </div>

                            {{-- Footer --}}
                            <div class="px-4 py-2 border-t border-gray-100 dark:border-gray-700">
                                <a href="{{ route('announcements.index') }}"
                                   class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    Lihat semua →
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- ── Dark Mode Toggle ── --}}
                    <button id="theme-toggle" type="button" title="Tukar Tema"
                            class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none">
                        {{-- Sun icon (shown in dark mode) --}}
                        <svg id="icon-sun" class="hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        {{-- Moon icon (shown in light mode) --}}
                        <svg id="icon-moon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                        </svg>
                    </button>

                    {{-- ── Profile Avatar Dropdown ── --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none"
                                title="Profil">
                            {{-- Avatar circle with initials --}}
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold uppercase flex-shrink-0">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="hidden sm:block text-left leading-tight">
                                <p class="text-xs font-semibold text-gray-800 dark:text-white max-w-[100px] truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-gray-400">{{ auth()->user()->getRoleNames()->first() }}</p>
                            </div>
                            <svg class="w-3 h-3 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Profile Dropdown --}}
                        <div x-show="open" x-transition
                             class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-700 z-50"
                             style="display:none;">

                            {{-- User info header --}}
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Menu items --}}
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Edit Profil
                                </a>
                            </div>

                            {{-- Logout --}}
                            <div class="py-1 border-t border-gray-100 dark:border-gray-700">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Log Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    {{-- ── Sidebar ── --}}
    <aside id="sidebar"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="h-full px-3 pb-4 overflow-y-auto">
            <ul class="space-y-1 pt-4 font-medium">

                @php $role = auth()->user()->getRoleNames()->first(); @endphp

                {{-- ── Menu Utama ── --}}
                @unless(auth()->user()->hasRole('Ibu Bapa'))
                <li>
                    <p class="px-2 pt-2 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Menu Utama</p>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center p-2 rounded-lg group transition-colors
                           {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="ms-3 text-sm">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengurusan.index') }}"
                       class="flex items-center p-2 rounded-lg group transition-colors
                           {{ request()->routeIs('pengurusan.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span class="ms-3 text-sm">Pengurusan Pentadbiran</span>
                    </a>
                </li>
                @endunless

                {{-- ── Ibu Bapa Portal ── --}}
                @hasrole('Ibu Bapa')
                <li>
                    <p class="px-2 pt-2 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Portal Ibu Bapa</p>
                </li>
                @foreach([
                    ['route'=>'parent.dashboard','label'=>'Laman Utama','icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route'=>'parent.results.index','label'=>'Keputusan Peperiksaan','icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['route'=>'attendances.index','label'=>'Rekod Kehadiran','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ] as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center p-2 rounded-lg group transition-colors text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                        <span class="ms-3 text-sm">{{ $item['label'] }}</span>
                    </a>
                </li>
                @endforeach
                @endhasrole

                {{-- ── Super Admin: Pemantauan ── --}}
                @role('Super Admin')
                <li>
                    <p class="px-2 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Pemantauan</p>
                </li>
                @foreach([
                    ['route'=>'chatbot.settings','label'=>'Tetapan Chatbot AI','icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                    ['route'=>'admin.manual.logs','label'=>'Log Panduan Pengguna','icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['route'=>'feedback.index','label'=>'Aduan Masalah','icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                    ['route'=>'admin.system_log','label'=>'Log Sistem','icon'=>'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ] as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center p-2 rounded-lg group transition-colors
                           {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                        <span class="ms-3 text-sm">{{ $item['label'] }}</span>
                    </a>
                </li>
                @endforeach
                @endrole

                {{-- ── Non-SA: Panduan ── --}}
                @unless(auth()->user()->hasRole('Super Admin'))
                <li>
                    <p class="px-2 pt-4 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Panduan</p>
                </li>
                <li>
                    <a href="{{ route('feedback.create') }}"
                       class="flex items-center p-2 rounded-lg group transition-colors text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span class="ms-3 text-sm">Laporkan Masalah</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" onclick="openPdfBlob(this, '{{ route('manual.download') }}')"
                       class="flex items-center p-2 rounded-lg group transition-colors text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span class="ms-3 text-sm">Panduan Pengguna</span>
                    </a>
                </li>
                @endunless

            </ul>
        </div>
    </aside>

    {{-- ── Backdrop (mobile) ── --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden"></div>

    {{-- ── Main Content ── --}}
    <div class="lg:ml-64 pt-16 min-h-screen">
        <main class="p-4 md:p-6">

            {{-- Flash messages --}}
            @if(session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <svg class="shrink-0 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                <span class="ms-3 text-sm font-medium">{{ session('success') }}</span>
                <button type="button" onclick="document.getElementById('alert-success').remove()" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="shrink-0 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                <span class="ms-3 text-sm font-medium">{{ session('error') }}</span>
                <button type="button" onclick="document.getElementById('alert-error').remove()" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                </button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- ── SweetAlert2 Global Handlers ── --}}
    <script>
        // Flash: Berjaya
        @if(session('success'))
        Swal.fire({
            title: 'Berjaya!',
            text: "{{ addslashes(session('success')) }}",
            icon: 'success',
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Tutup',
            timer: 4000,
            timerProgressBar: true
        });
        @endif

        // Flash: Ralat
        @if(session('error'))
        Swal.fire({
            title: 'Ralat!',
            text: "{{ addslashes(session('error')) }}",
            icon: 'error',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Tutup'
        });
        @endif

        // Global: data-delete-form confirmation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-delete-form]').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var itemName = form.getAttribute('data-name') || 'rekod ini';
                    Swal.fire({
                        title: 'Pengesahan',
                        html: 'Adakah anda pasti mahu memadam <strong>' + itemName + '</strong>?<br><small style="color:#999;">Tindakan ini tidak boleh dikembalikan.</small>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Teruskan!',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>

    {{-- ── PDF Viewer Overlay (PDF.js) ── --}}
    <div id="rph-pdf-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:99998; background:#333;">
        <div style="position:absolute; top:0; left:0; right:0; height:48px; background:#1a1a2e; color:white; display:flex; justify-content:space-between; align-items:center; padding:0 18px; gap:10px; z-index:2;">
            <span style="font-weight:600; font-size:0.95em;">📄 Paparan PDF</span>
            <div style="display:flex; gap:8px; align-items:center;">
                <a id="rph-pdf-download-link" href="#" download style="color:#aaa; font-size:0.82em; text-decoration:none; padding:4px 12px; border:1px solid #555; border-radius:4px; white-space:nowrap;">⬇ Simpan</a>
                <button onclick="closePdfViewer()" style="background:#dc3545; color:white; border:none; padding:5px 16px; border-radius:4px; cursor:pointer; font-size:0.88em;">✕ Tutup</button>
            </div>
        </div>
        <div id="rph-pdf-container" style="position:absolute; top:48px; left:0; right:0; bottom:0; overflow-y:auto; background:#525659; display:flex; flex-direction:column; align-items:center; padding:20px 0; gap:12px;"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        }

        var _pdfBlobUrl = null;

        function openPdfBlob(btn, url) {
            var overlay   = document.getElementById('rph-pdf-overlay');
            var container = document.getElementById('rph-pdf-container');
            var dlLink    = document.getElementById('rph-pdf-download-link');

            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
            container.innerHTML = '<div style="color:#ccc; margin-top:60px; font-size:1em; font-family:Arial,sans-serif;">Memuatkan PDF...</div>';

            fetch(url, {
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function(res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function(json) {
                var binary = atob(json.data);
                var bytes  = new Uint8Array(binary.length);
                for (var i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
                var buffer = bytes.buffer;

                var blob = new Blob([buffer], { type: 'application/pdf' });
                if (_pdfBlobUrl) URL.revokeObjectURL(_pdfBlobUrl);
                _pdfBlobUrl = URL.createObjectURL(blob);
                dlLink.href = _pdfBlobUrl;
                dlLink.download = json.filename || 'dokumen.pdf';

                return pdfjsLib.getDocument({ data: buffer }).promise;
            })
            .then(function(pdfDoc) {
                container.innerHTML = '';
                var renderPage = function(pageNum) {
                    return pdfDoc.getPage(pageNum).then(function(page) {
                        var desiredWidth = Math.min(container.clientWidth - 40, 860);
                        var viewport0    = page.getViewport({ scale: 1 });
                        var scale        = desiredWidth / viewport0.width;
                        var viewport     = page.getViewport({ scale: scale });
                        var canvas       = document.createElement('canvas');
                        canvas.width     = viewport.width;
                        canvas.height    = viewport.height;
                        canvas.style.cssText = 'display:block; box-shadow:0 2px 10px rgba(0,0,0,0.6); background:#fff; flex-shrink:0;';
                        container.appendChild(canvas);
                        return page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise;
                    });
                };
                var chain = Promise.resolve();
                for (var i = 1; i <= pdfDoc.numPages; i++) chain = chain.then(renderPage.bind(null, i));
                return chain;
            })
            .catch(function(err) {
                overlay.style.display = 'none';
                document.body.style.overflow = '';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Ralat', text: 'Gagal memuatkan PDF: ' + err.message, icon: 'error', confirmButtonColor: '#dc3545' });
                } else {
                    alert('Gagal memuatkan PDF: ' + err.message);
                }
            });
        }

        function renderPdfBase64(base64) {
            var overlay   = document.getElementById('rph-pdf-overlay');
            var container = document.getElementById('rph-pdf-container');
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
            container.innerHTML = '<div style="color:#ccc;margin-top:60px;font-size:1em;font-family:Arial,sans-serif;">Memuatkan PDF...</div>';

            var binary = atob(base64);
            var bytes  = new Uint8Array(binary.length);
            for (var i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);

            pdfjsLib.getDocument({ data: bytes.buffer }).promise
            .then(function(pdfDoc) {
                container.innerHTML = '';
                var renderPage = function(pageNum) {
                    return pdfDoc.getPage(pageNum).then(function(page) {
                        var desiredWidth = Math.min(container.clientWidth - 40, 860);
                        var viewport0    = page.getViewport({ scale: 1 });
                        var scale        = desiredWidth / viewport0.width;
                        var viewport     = page.getViewport({ scale: scale });
                        var canvas       = document.createElement('canvas');
                        canvas.width     = viewport.width;
                        canvas.height    = viewport.height;
                        canvas.style.cssText = 'display:block;box-shadow:0 2px 10px rgba(0,0,0,.6);background:#fff;flex-shrink:0;';
                        container.appendChild(canvas);
                        return page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise;
                    });
                };
                var chain = Promise.resolve();
                for (var i = 1; i <= pdfDoc.numPages; i++) chain = chain.then(renderPage.bind(null, i));
                return chain;
            })
            .catch(function(err) {
                overlay.style.display = 'none';
                document.body.style.overflow = '';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Ralat', text: 'Gagal memuatkan PDF: ' + err.message, icon: 'error', confirmButtonColor: '#dc3545' });
                }
            });
        }

        function closePdfViewer() {
            var overlay   = document.getElementById('rph-pdf-overlay');
            var container = document.getElementById('rph-pdf-container');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
            container.innerHTML = '';
            if (_pdfBlobUrl) {
                setTimeout(function() { URL.revokeObjectURL(_pdfBlobUrl); _pdfBlobUrl = null; }, 500);
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var overlay = document.getElementById('rph-pdf-overlay');
                if (overlay && overlay.style.display === 'block') closePdfViewer();
            }
        });
    </script>

    @stack('scripts')

    {{-- ── Global File Input Filename Display ── --}}
    <script>
    function updateFilename(input, spanId) {
        var span = document.getElementById(spanId);
        if (span) {
            span.textContent = input.files && input.files[0] ? input.files[0].name : 'Tiada fail dipilih';
        }
    }
    </script>

    {{-- ── Global Date Input Styling (native type="date" — no overlay issues) ── --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[type="date"]').forEach(function(el) {
            // Add calendar icon via wrapper (inline style — VPS-safe)
            var wrapper = document.createElement('div');
            wrapper.style.cssText = 'position:relative;display:inline-block;';
            el.parentNode.insertBefore(wrapper, el);
            wrapper.appendChild(el);

            var icon = document.createElement('div');
            icon.style.cssText = 'position:absolute;top:50%;left:0.625rem;transform:translateY(-50%);pointer-events:none;line-height:0;';
            icon.innerHTML = '<svg style="width:1rem;height:1rem;color:#6b7280;" fill="currentColor" viewBox="0 0 20 20"><path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/></svg>';
            wrapper.insertBefore(icon, el);

            el.style.paddingLeft = '2.25rem';
        });
    });
    </script>

    {{-- ── Dark Mode Toggle ── --}}
    <script>
    (function() {
        var html  = document.documentElement;
        var saved = localStorage.getItem('theme');
        if (saved === 'light') html.classList.remove('dark');
        else html.classList.add('dark');
    })();

    document.addEventListener('DOMContentLoaded', function() {
        var btn     = document.getElementById('theme-toggle');
        var sun     = document.getElementById('icon-sun');
        var moon    = document.getElementById('icon-moon');
        var html    = document.documentElement;

        function applyTheme(dark) {
            if (dark) {
                html.classList.add('dark');
                sun.classList.remove('hidden');
                moon.classList.add('hidden');
                localStorage.setItem('theme', 'dark');
            } else {
                html.classList.remove('dark');
                sun.classList.add('hidden');
                moon.classList.remove('hidden');
                localStorage.setItem('theme', 'light');
            }
        }

        // Init icon on load — default dark
        var saved = localStorage.getItem('theme');
        applyTheme(saved !== 'light');

        btn.addEventListener('click', function() {
            applyTheme(!html.classList.contains('dark'));
        });
    });
    </script>

    {{-- Chatbot widget — visible for all authenticated users --}}
    @auth
    <x-chatbot-widget />
    @endauth
</body>
</html>
