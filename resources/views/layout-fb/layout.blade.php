<!DOCTYPE html>
<html lang="ms" class="h-full">
@php
    $authUser     = auth()->user();
    $userRole     = $authUser->getRoleNames()->first();
    $userSchool   = $authUser->school;
    $initials     = collect(preg_split('/\s+/', trim($authUser->name)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    $roleBadge    = match ($userRole) {
        'Guru Besar' => 'ek-badge-blue',
        'Guru KAFA'  => 'bg-indigo-100 text-indigo-700',
        'Ibu Bapa'   => 'bg-teal-100 text-teal-700',
        default      => 'ek-badge-gray',
    };
    $isParentOnly = $authUser->hasRole('Ibu Bapa') && !$authUser->hasAnyRole(['Super Admin', 'Guru Besar', 'Guru KAFA']);
    $menuGroups   = $isParentOnly ? [] : \App\Support\SidebarMenu::for($authUser);
    $activeLabel  = collect($menuGroups)->pluck('items')->flatten(1)->firstWhere('active', true)['label'] ?? 'eKafa Online';
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title')@else{{ $activeLabel }}@endif | eKafa Online</title>
    <link rel="shortcut icon" href="{{ asset('template/perak.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @font-face { font-family: 'LateefLocal'; src: url('{{ asset('fonts/Lateef-Regular.ttf') }}') format('truetype'); font-display: swap; }
        .jawi { font-family: 'LateefLocal', 'Lateef', serif; line-height: 1.8; }
        .ek-scroll { scrollbar-width: thin; }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-gray-50 text-gray-900 antialiased" x-data="{ sidebarOpen: false }">

    {{-- ── Sidebar (drawer on mobile) ── --}}
    <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden" aria-hidden="true"></div>

    <aside id="sidebar"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col border-r border-gray-200 bg-white transition-transform duration-300 lg:z-30 lg:translate-x-0"
           aria-label="Menu sisi">
        <div class="flex items-center gap-2.5 border-b border-gray-100 px-5 py-4">
            <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-2.5">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold text-white shadow-md shadow-blue-600/30">eK</span>
                <span class="min-w-0 leading-tight">
                    <span class="block text-[15px] font-bold tracking-tight text-gray-900">eKafa <span class="text-blue-600">Online</span></span>
                    <span class="flex items-center gap-1.5 text-[11px] text-gray-500">Pengurusan KAFA <span class="jawi text-[13px]" dir="rtl" lang="ms-Arab">ڤڠوروسن کفا</span></span>
                </span>
            </a>
            <button type="button" class="ek-btn-icon ml-auto lg:hidden" @click="sidebarOpen = false" aria-label="Tutup menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="ek-scroll flex-1 overflow-y-auto px-3 py-4">

            {{-- ── Module menu (App\Support\SidebarMenu: role + plan aware) ── --}}
            @foreach($menuGroups as $group)
            <div class="mb-5">
                <p class="ek-nav-heading">{{ $group['title'] }}</p>
                @foreach($group['items'] as $item)
                <a href="{{ $item['url'] }}" class="ek-nav-link {{ $item['active'] ? 'is-active' : '' }} {{ $item['locked'] ? 'text-gray-500 hover:bg-gray-50' : '' }}"
                   @if($item['locked']) title="Tersedia dalam pelan {{ $item['planLabel'] }}" @endif>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>
                    @if($item['locked'])
                    <span class="inline-flex shrink-0 items-center gap-0.5 rounded-full px-1.5 py-0.5 text-[10px] font-semibold {{ $item['plan'] === 'sekolah' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700' }}">
                        <svg class="!h-3 !w-3 !text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>{{ $item['planLabel'] }}
                    </span>
                    @endif
                </a>
                @endforeach
            </div>
            @endforeach

            {{-- ── Ibu Bapa Portal ── --}}
            @hasrole('Ibu Bapa')
            <div class="mb-5">
                <p class="ek-nav-heading">Portal Ibu Bapa</p>
                @foreach([
                    ['route'=>'parent.dashboard','label'=>'Laman Utama','icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route'=>'parent.results.index','label'=>'Keputusan Peperiksaan','icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['route'=>'attendances.index','label'=>'Rekod Kehadiran','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ] as $item)
                <a href="{{ route($item['route']) }}" class="ek-nav-link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </div>
            @endhasrole

            {{-- ── Non-SA: Panduan ── --}}
            @unless($authUser->hasRole('Super Admin'))
            <div class="mb-5">
                <p class="ek-nav-heading">Panduan</p>
                <a href="{{ route('feedback.create') }}" class="ek-nav-link {{ request()->routeIs('feedback.create') ? 'is-active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span class="min-w-0 flex-1 truncate">Laporkan Masalah</span>
                </a>
                <a href="javascript:void(0);" onclick="openPdfBlob(this, '{{ route('manual.download') }}')" class="ek-nav-link">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="min-w-0 flex-1 truncate">Panduan Pengguna</span>
                </a>
            </div>
            @endunless
        </nav>

        {{-- ── Current plan card ── --}}
        @if($userSchool && !$authUser->hasRole('Ibu Bapa'))
        @php
            $planKey   = $userSchool->effectivePlan();
            $planPrice = config("plans.plans.$planKey.price", 0);
            $topPlan   = collect(config('plans.types.'.($userSchool->type ?? 'sekolah').'.plans', []))->last();
        @endphp
        <div class="border-t border-gray-100 p-4">
            <div class="rounded-xl bg-gradient-to-br from-blue-50 to-teal-50 p-4 ring-1 ring-blue-100">
                <p class="text-xs text-gray-600">Pelan semasa</p>
                <p class="text-sm font-bold text-gray-900">{{ $userSchool->planLabel() }} <span class="font-medium text-gray-600">· RM{{ $planPrice }}{{ $planPrice ? '/bulan' : '' }}</span></p>
                @if($topPlan && $planKey !== $topPlan && $userSchool->owner_id == $authUser->id)
                <a href="{{ route('subscription.index') }}" class="mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Naik Taraf</a>
                @endif
            </div>
        </div>
        @endif
    </aside>

    {{-- ── Main column ── --}}
    <div class="min-h-full lg:pl-64">
        <header class="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-gray-200 bg-white/90 px-4 backdrop-blur sm:px-6 lg:px-8">
            <button type="button" @click="sidebarOpen = true" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 lg:hidden" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-gray-900 sm:text-base">@hasSection('title')@yield('title')@else{{ $activeLabel }}@endif</p>
                @if($userSchool)
                <p class="hidden truncate text-xs text-gray-500 sm:block">{{ $userSchool->name }}</p>
                @endif
            </div>

            <span class="ek-badge {{ $roleBadge }} hidden font-semibold sm:inline-flex">{{ $authUser->roleLabel() }}</span>

            @php
                $unreadCount  = $authUser->unreadNotifications()->count();
                $recentNotifs = $authUser->unreadNotifications()->latest()->take(5)->get();
            @endphp

            {{-- ── Bell Notification ── --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false" class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700" title="Pemberitahuan">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if($unreadCount > 0)
                    <span class="absolute right-1 top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold leading-none text-white">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </button>

                <div x-show="open" x-cloak x-transition class="absolute right-0 z-50 mt-2 w-80 rounded-xl border border-gray-200 bg-white shadow-lg">
                    <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                        <h6 class="text-sm font-semibold text-gray-900">Pemberitahuan</h6>
                        @if($unreadCount > 0)
                        <form method="POST" action="{{ route('notifications.markRead') }}">
                            @csrf
                            <button type="submit" class="text-xs text-blue-600 hover:underline">Tandakan semua dibaca</button>
                        </form>
                        @endif
                    </div>
                    <div class="max-h-72 divide-y divide-gray-50 overflow-y-auto">
                        @forelse($recentNotifs as $notif)
                        <a href="{{ route('notifications.read', $notif->id) }}" class="flex items-start gap-3 px-4 py-3 transition-colors hover:bg-gray-50">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="line-clamp-2 block text-xs font-medium leading-snug text-gray-900">{{ $notif->data['title'] ?? $notif->data['message'] ?? 'Pemberitahuan baharu' }}</span>
                                <span class="mt-0.5 block text-[11px] text-gray-500">{{ $notif->created_at->diffForHumans() }}</span>
                            </span>
                            <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                        </a>
                        @empty
                        <div class="px-4 py-6 text-center">
                            <svg class="mx-auto mb-2 h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <p class="text-xs text-gray-500">Tiada pemberitahuan baharu</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="border-t border-gray-100 px-4 py-2">
                        <a href="{{ route('announcements.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Lihat semua →</a>
                    </div>
                </div>
            </div>

            {{-- ── Profile dropdown ── --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2.5 rounded-lg p-1 hover:bg-gray-100" title="Profil">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-xs font-bold text-white" aria-hidden="true">{{ $initials }}</span>
                    <span class="hidden text-left leading-tight md:block">
                        <span class="block max-w-[160px] truncate text-sm font-semibold text-gray-900">{{ $authUser->name }}</span>
                        <span class="block text-xs text-gray-500">{{ $authUser->roleLabel() }}</span>
                    </span>
                    <svg class="hidden h-3 w-3 text-gray-400 md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="open" x-cloak x-transition class="absolute right-0 z-50 mt-2 w-56 rounded-xl border border-gray-200 bg-white shadow-lg">
                    <div class="border-b border-gray-100 px-4 py-3">
                        <p class="truncate text-sm font-semibold text-gray-900">{{ $authUser->name }}</p>
                        <p class="truncate text-xs text-gray-500">{{ $authUser->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 transition-colors hover:bg-gray-50">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Edit Profil
                        </a>
                    </div>
                    <div class="border-t border-gray-100 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 transition-colors hover:bg-red-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Log Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-4 py-6 sm:px-6 lg:px-8">

            {{-- Flash messages --}}
            @if(session('success'))
            <div id="alert-success" class="mb-4 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800" role="alert">
                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
                <button type="button" onclick="document.getElementById('alert-success').remove()" class="ek-btn-icon ml-auto text-green-600 hover:bg-green-100" aria-label="Tutup">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div id="alert-error" class="mb-4 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800" role="alert">
                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm1 14.5H9v-2h2v2Zm0-4H9V5h2v6Z"/></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
                <button type="button" onclick="document.getElementById('alert-error').remove()" class="ek-btn-icon ml-auto text-red-600 hover:bg-red-100" aria-label="Tutup">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
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

        function ekEscape(s) {
            return String(s).replace(/[&<>"']/g, function(c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; });
        }

        // Global: data-confirm="message" on a form (submit) or a submit button (click)
        document.addEventListener('submit', function(e) {
            var form = e.target;
            var msg  = form.dataset.confirm || (e.submitter && e.submitter.dataset.confirm);
            if (!msg || form.dataset.confirmed) return;
            e.preventDefault();
            Swal.fire({
                title: 'Pengesahan',
                text: msg,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Teruskan',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (!result.isConfirmed) return;
                form.dataset.confirmed = '1';
                form.requestSubmit(e.submitter || undefined);
            });
        });

        // Global: data-delete-form confirmation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-delete-form]').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var itemName = ekEscape(form.getAttribute('data-name') || 'rekod ini');
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

    {{-- Chatbot widget — only when the workspace plan includes the AI assistant --}}
    @auth
    @if(auth()->user()->canUse('chatbot'))
    <x-chatbot-widget />
    @endif
    @endauth
</body>
</html>
