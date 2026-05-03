@section('title', 'Log Masuk')
@extends('layout-fb.auth')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4">
    <div class="max-w-6xl mx-auto">

        {{-- ── Hero: Heading-mark pattern ── --}}
        <div class="text-center mb-8">
            <img src="{{ asset('template/perak.png') }}"
                 alt="Logo APKM" class="h-16 mx-auto mb-5 drop-shadow">
            <h1 class="mb-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white md:text-5xl">
                Pengurusan KAFA
                <mark class="px-2 pb-0.5 text-white bg-blue-600 rounded-lg">lebih mudah</mark>
            </h1>
            <p class="text-lg font-normal text-gray-600 dark:text-gray-400">
                Aplikasi Pengurusan KAFA Daerah Manjung — sistem bersepadu untuk pentadbir, guru, dan ibu bapa.
            </p>
        </div>

        {{-- ── Two-column grid (equal height via items-stretch) ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">

            {{-- ── LEFT: Login Form Card ── --}}
            <div class="w-full bg-white dark:bg-gray-800 p-6 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm h-full">

                {{-- Login type tabs --}}
                <div class="flex gap-2 mb-5 p-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <button type="button" id="tab-staff" onclick="switchLoginType('staff')"
                            class="flex-1 py-2 text-sm font-semibold rounded-md bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm transition-all">
                        🏢 Kakitangan
                    </button>
                    <button type="button" id="tab-parent" onclick="switchLoginType('parent')"
                            class="flex-1 py-2 text-sm font-semibold rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-all">
                        👨‍👩‍👧‍👦 Ibu Bapa
                    </button>
                </div>

                {{-- Heading --}}
                <h5 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Log masuk ke sistem</h5>

                {{-- Session status --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="login_type" id="login_type" value="{{ old('login_type', 'staff') }}">

                    {{-- Login ID --}}
                    <div class="mb-4">
                        <label for="login_id" id="login_label"
                               class="block mb-2.5 text-sm font-medium text-gray-900 dark:text-white">
                            Alamat Emel
                        </label>
                        <input type="{{ old('login_type') === 'parent' ? 'text' : 'email' }}"
                               id="login_id" name="login_id"
                               value="{{ old('login_id') }}"
                               required autofocus
                               placeholder="{{ old('login_type') === 'parent' ? 'Contoh: 890101-10-5555' : 'nama@sekolah.edu.my' }}"
                               class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 @error('login_id') border-red-500 @enderror">
                        @error('login_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="relative">
                        <label for="password-field"
                               class="block mb-2.5 text-sm font-medium text-gray-900 dark:text-white">
                            Kata Laluan
                        </label>
                        <input type="password" id="password-field" name="password"
                               required placeholder="••••••••••"
                               class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5 pr-10 shadow-sm @error('password') border-red-500 @enderror">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                style="top:38px;">
                            <svg id="icon-eye" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="icon-eye-off" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                        @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-start my-6">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                   class="w-4 h-4 border border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-blue-300">
                            <label for="remember_me" class="ms-2 text-sm font-medium text-gray-900 dark:text-white">
                                Ingat Saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="ms-auto text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            Lupa Kata Laluan?
                        </a>
                        @endif
                    </div>

                    <button type="submit"
                            class="text-white bg-blue-600 border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-sm font-medium leading-5 rounded-lg text-sm px-4 py-2.5 focus:outline-none w-full mb-3 flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk ke Akaun
                    </button>

                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
                        Ada masalah log masuk?
                        <a href="{{ route('feedback.create') }}"
                           class="text-blue-600 dark:text-blue-400 hover:underline">
                            Hubungi pentadbir
                        </a>
                    </div>
                </form>
            </div>

            {{-- ── RIGHT: Announcements — Horizontal Card ── --}}
            <div class="flex flex-col bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm h-full overflow-hidden">

                {{-- Featured announcement: Horizontal Card layout --}}
                @php $featured = $announcements->first(); @endphp
                @if($featured)
                @php
                    $labelColors = [
                        'Ciri Baharu'     => 'bg-green-100 text-green-700',
                        'Pembaikan'       => 'bg-cyan-100 text-cyan-700',
                        'Penyelenggaraan' => 'bg-yellow-100 text-yellow-700',
                        'Kritikal'        => 'bg-red-100 text-red-700',
                        'Pengumuman'      => 'bg-blue-100 text-blue-700',
                    ];
                    $lblClass   = $labelColors[$featured->homepage_label] ?? 'bg-gray-100 text-gray-600';
                    $labelIcons = ['Ciri Baharu'=>'🆕','Pembaikan'=>'🔧','Penyelenggaraan'=>'⚠️','Kritikal'=>'🚨','Pengumuman'=>'📢'];
                    $lblIcon    = $labelIcons[$featured->homepage_label] ?? '📢';
                @endphp

                {{-- Horizontal card: banner top on mobile, side-by-side on desktop --}}
                <div class="flex flex-col lg:flex-row w-full">
                    {{-- Banner / image side --}}
                    <div class="lg:w-48 lg:flex-shrink-0 flex-shrink-0">
                        <div class="h-40 lg:h-full flex items-center justify-center text-5xl"
                             style="background: linear-gradient(135deg,#dbeafe,#ede9fe);">
                            <span>{{ $lblIcon }}</span>
                        </div>
                    </div>
                    {{-- Content side --}}
                    <div class="flex flex-col justify-between p-5 leading-normal w-full">
                        <div>
                            <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full mb-2 {{ $lblClass }}">
                                {{ $featured->homepage_label ?? 'Hebahan Umum' }}
                            </span>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                                {{ $featured->title }}
                            </h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($featured->content), 140) }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="showAnnouncementModal({{ $featured->id }})"
                                    class="inline-flex items-center text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 shadow-sm font-medium leading-5 rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors">
                                Baca Lanjut
                                <svg class="w-4 h-4 ms-1.5 -me-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                                </svg>
                            </button>
                            <span class="text-xs text-gray-400">{{ $featured->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Hidden data for modal --}}
                <div id="announcement-data-{{ $featured->id }}" class="hidden"
                     data-title="{{ $featured->title }}"
                     data-author="{{ $featured->user->name }}"
                     data-is-admin="{{ $featured->user->hasRole('Super Admin') ? '1' : '0' }}"
                     data-date="{{ $featured->created_at->format('d/m/Y') }}"
                     data-label="{{ $featured->homepage_label }}"
                     data-view-count="{{ $featured->view_count }}"
                     data-readers-count="{{ $featured->authenticated_readers_count }}"
                     data-announcement-id="{{ $featured->id }}">
                    {!! $featured->content !!}
                </div>

                {{-- Remaining announcements as compact list --}}
                @if($announcements->count() > 1)
                <div class="flex-1 border-t border-gray-100 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700 overflow-y-auto" style="max-height:220px;">
                    @foreach($announcements->skip(1) as $announcement)
                    @php
                        $lc2 = $labelColors[$announcement->homepage_label] ?? 'bg-gray-100 text-gray-600';
                        $li2 = $labelIcons[$announcement->homepage_label] ?? '📢';
                    @endphp
                    <div class="px-5 py-3">
                        <div class="flex items-start gap-3">
                            <span class="text-lg leading-none mt-0.5">{{ $li2 }}</span>
                            <div class="flex-1 min-w-0">
                                <button type="button" onclick="showAnnouncementModal({{ $announcement->id }})"
                                        class="text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 text-left w-full line-clamp-1">
                                    {{ $announcement->title }}
                                </button>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $announcement->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        {{-- Hidden data --}}
                        <div id="announcement-data-{{ $announcement->id }}" class="hidden"
                             data-title="{{ $announcement->title }}"
                             data-author="{{ $announcement->user->name }}"
                             data-is-admin="{{ $announcement->user->hasRole('Super Admin') ? '1' : '0' }}"
                             data-date="{{ $announcement->created_at->format('d/m/Y') }}"
                             data-label="{{ $announcement->homepage_label }}"
                             data-view-count="{{ $announcement->view_count }}"
                             data-readers-count="{{ $announcement->authenticated_readers_count }}"
                             data-announcement-id="{{ $announcement->id }}">
                            {!! $announcement->content !!}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @else
                {{-- Empty state --}}
                <div class="flex-1 flex flex-col items-center justify-center py-12 text-center px-6">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tiada Hebahan Baharu</p>
                    <p class="text-xs text-gray-400 mt-1">Sila semak semula kemudian.</p>
                </div>
                @endif

                <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <p class="text-xs text-gray-400 dark:text-gray-500 text-center">
                        * Log masuk untuk melihat semua hebahan.
                    </p>
                </div>
            </div>

        </div>{{-- end grid --}}

        {{-- ── Prayer Times Widget ── --}}
        <div class="mt-6">
            <x-prayer-times-widget />
        </div>

    </div>
</div>

{{-- ── Announcement Modal ── --}}
<div id="announcementModal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/60 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-2xl max-h-screen flex flex-col overflow-hidden"
         style="max-height:90vh;">
        <div class="p-6 flex-shrink-0"
             style="background:linear-gradient(135deg,#1d4ed8,#4f46e5);">
            <div class="flex items-start justify-between mb-2">
                <span id="modalLabel"
                      class="px-3 py-1 text-xs font-bold rounded-full"
                      style="background:rgba(255,255,255,0.2);color:#fff;">📢 Pengumuman</span>
                <button type="button" onclick="closeAnnouncementModal()"
                        class="text-white hover:text-white/80">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <h3 id="modalTitle" class="text-lg font-bold leading-snug text-white"></h3>
            <div class="flex items-center gap-3 mt-2 text-sm" style="color:rgba(255,255,255,0.85);">
                <span id="modalAuthor"></span>
                <span id="modalAdminBadge" class="hidden px-2 py-0.5 text-xs font-semibold rounded-full"
                      style="background:rgba(255,255,255,0.25);">✓ Pentadbir Sistem</span>
                <span id="modalDate" class="text-xs" style="color:rgba(255,255,255,0.7);"></span>
            </div>
        </div>
        <div class="overflow-y-auto flex-1 p-6">
            <div id="modalBody"
                 class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line"></div>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end flex-shrink-0">
            <button type="button" onclick="closeAnnouncementModal()"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Faham
            </button>
        </div>
    </div>
</div>

<script>
function switchLoginType(type) {
    var loginType  = document.getElementById('login_type');
    var loginId    = document.getElementById('login_id');
    var loginLabel = document.getElementById('login_label');
    var tabStaff   = document.getElementById('tab-staff');
    var tabParent  = document.getElementById('tab-parent');
    loginType.value = type;

    var active   = ['bg-white','dark:bg-gray-600','text-blue-600','dark:text-blue-400','shadow-sm'];
    var inactive = ['text-gray-500','dark:text-gray-400'];

    if (type === 'staff') {
        loginLabel.textContent    = 'Alamat Emel';
        loginId.type              = 'email';
        loginId.placeholder       = 'nama@sekolah.edu.my';
        active.forEach(function(c)   { tabStaff.classList.add(c);   tabParent.classList.remove(c); });
        inactive.forEach(function(c) { tabParent.classList.add(c);  tabStaff.classList.remove(c);  });
    } else {
        loginLabel.textContent    = 'No. Kad Pengenalan Ibu/Bapa';
        loginId.type              = 'text';
        loginId.placeholder       = 'Contoh: 890101-10-5555';
        active.forEach(function(c)   { tabParent.classList.add(c);  tabStaff.classList.remove(c);  });
        inactive.forEach(function(c) { tabStaff.classList.add(c);   tabParent.classList.remove(c); });
    }
}

function togglePassword() {
    var f = document.getElementById('password-field');
    var e = document.getElementById('icon-eye');
    var o = document.getElementById('icon-eye-off');
    if (f.type === 'password') {
        f.type = 'text'; e.classList.add('hidden'); o.classList.remove('hidden');
    } else {
        f.type = 'password'; e.classList.remove('hidden'); o.classList.add('hidden');
    }
}

var labelIcons = { 'Ciri Baharu':'🆕','Pembaikan':'🔧','Penyelenggaraan':'⚠️','Kritikal':'🚨','Pengumuman':'📢' };

function showAnnouncementModal(id) {
    var d          = document.getElementById('announcement-data-' + id);
    var viewCount  = parseInt(d.getAttribute('data-view-count')) || 0;
    var annId      = d.getAttribute('data-announcement-id');
    var label      = d.getAttribute('data-label');

    document.getElementById('modalTitle').textContent  = d.getAttribute('data-title');
    document.getElementById('modalBody').innerHTML     = d.innerHTML;
    document.getElementById('modalAuthor').textContent = '👤 ' + d.getAttribute('data-author');
    document.getElementById('modalDate').textContent   = '📅 ' + d.getAttribute('data-date');
    document.getElementById('modalLabel').textContent  = (labelIcons[label] || '📢') + ' ' + (label || 'Hebahan Umum');

    var badge = document.getElementById('modalAdminBadge');
    d.getAttribute('data-is-admin') === '1'
        ? badge.classList.remove('hidden')
        : badge.classList.add('hidden');

    document.getElementById('announcementModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    fetch('/announcements/' + annId + '/increment-view', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
}

function closeAnnouncementModal() {
    document.getElementById('announcementModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

document.getElementById('announcementModal').addEventListener('click', function(e) {
    if (e.target === this) closeAnnouncementModal();
});

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('login_type').value === 'parent') switchLoginType('parent');
});
</script>
@endsection
