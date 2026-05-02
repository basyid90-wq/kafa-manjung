<!DOCTYPE html>
<html lang="ms" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'APKM') | Sistem KAFA Perak</title>
    <link rel="shortcut icon" href="{{ asset('template/perak.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                            APKM<br><span class="text-xs font-normal text-gray-500">Sistem KAFA Perak</span>
                        </span>
                    </a>
                </div>
                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 dark:text-gray-300 hidden sm:block">
                        {{ auth()->user()->name }}
                        <span class="ms-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                            {{ auth()->user()->getRoleNames()->first() }}
                        </span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg dark:text-gray-400 dark:hover:bg-gray-700" title="Log Keluar">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
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
                    ['route'=>'admin.manual.logs','label'=>'Log Panduan Pengguna','icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['route'=>'feedback.index','label'=>'Aduan Masalah','icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
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

    @stack('scripts')
</body>
</html>
