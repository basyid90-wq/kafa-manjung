@section('title', 'Log Masuk')
@extends('layout-fb.auth')

@section('content')
<div class="min-h-screen flex flex-col">

    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-4 px-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang ke APKM</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Aplikasi Pengurusan KAFA Daerah Manjung</p>
    </div>

    <div class="flex-1 flex items-start justify-center py-8 px-4">
        <div class="w-full max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                {{-- Login Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">

                        <div class="text-center mb-5">
                            <img src="{{ asset('template/perak.png') }}" alt="Logo Perak" class="h-20 mx-auto mb-3">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Log Masuk Sistem</h2>
                        </div>

                        {{-- Session Status --}}
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        {{-- Login Type Tabs --}}
                        <div class="flex gap-2 mb-5 p-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <button type="button" id="tab-staff"
                                    onclick="switchLoginType('staff')"
                                    class="flex-1 py-2 text-sm font-semibold rounded-md bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm transition-all">
                                🏢 Kakitangan
                            </button>
                            <button type="button" id="tab-parent"
                                    onclick="switchLoginType('parent')"
                                    class="flex-1 py-2 text-sm font-semibold rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-all">
                                👨‍👩‍👧‍👦 Ibu Bapa
                            </button>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="login_type" id="login_type" value="{{ old('login_type', 'staff') }}">

                            <div>
                                <label for="login_id" id="login_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Alamat Emel
                                </label>
                                <input id="login_id" name="login_id"
                                       type="{{ old('login_type') === 'parent' ? 'text' : 'email' }}"
                                       value="{{ old('login_id') }}"
                                       required autofocus
                                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('login_id') border-red-500 @enderror">
                                @error('login_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative">
                                <label for="password-field" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Kata Laluan
                                </label>
                                <input id="password-field" name="password" type="password" required
                                       class="w-full px-3 py-2 pr-10 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                <button type="button" onclick="togglePassword()"
                                        class="absolute right-3 top-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
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

                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="remember" id="remember_me"
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Ingat Saya</span>
                                </label>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    Lupa Kata Laluan?
                                </a>
                                @endif
                            </div>

                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Masuk Sekarang
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Announcements Panel --}}
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 h-full">
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">Info Terkini</span>
                            <h2 class="text-base font-bold text-gray-900 dark:text-white mt-2">Papan Makluman Utama</h2>
                        </div>

                        <div class="space-y-4">
                            @forelse($announcements as $announcement)
                            @php
                                $labelColors = [
                                    'Ciri Baharu'     => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    'Pembaikan'       => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                    'Penyelenggaraan' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'Kritikal'        => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                    'Pengumuman'      => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                ];
                                $labelIcons = [
                                    'Ciri Baharu' => '🆕', 'Pembaikan' => '🔧',
                                    'Penyelenggaraan' => '⚠️', 'Kritikal' => '🚨', 'Pengumuman' => '📢'
                                ];
                                $lblClass = $labelColors[$announcement->homepage_label] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300';
                                $lblIcon = $labelIcons[$announcement->homepage_label] ?? '📢';
                            @endphp
                            <div class="pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $lblClass }}">
                                        {{ $lblIcon }} {{ $announcement->homepage_label ?? 'Hebahan Umum' }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $announcement->created_at->format('d/m/Y') }}</span>
                                </div>
                                <button type="button" onclick="showAnnouncementModal({{ $announcement->id }})"
                                        class="text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 text-left w-full">
                                    {{ $announcement->title }}
                                </button>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 120) }}
                                </p>
                                @if(strlen(strip_tags($announcement->content)) > 120)
                                <button type="button" onclick="showAnnouncementModal({{ $announcement->id }})"
                                        class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-1">
                                    Baca Selanjutnya →
                                </button>
                                @endif
                                {{-- Hidden data for modal --}}
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
                            @empty
                            <div class="text-center py-10">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tiada Hebahan Baharu</p>
                                <p class="text-xs text-gray-400 mt-1">Sila semak semula kemudian.</p>
                            </div>
                            @endforelse
                        </div>

                        @if($announcements->count() > 0)
                        <p class="text-xs text-gray-400 mt-4 text-center">* Sila log masuk untuk melihat butiran penuh hebahan.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Announcement Modal --}}
<div id="announcementModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/60 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
        {{-- Modal Header --}}
        <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex-shrink-0">
            <div class="flex items-start justify-between mb-2">
                <span id="modalLabel" class="px-3 py-1 text-xs font-bold bg-white/20 rounded-full">📢 Pengumuman</span>
                <button type="button" onclick="closeAnnouncementModal()"
                        class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <h3 id="modalTitle" class="text-lg font-bold leading-snug"></h3>
            <div class="flex items-center gap-3 mt-2 text-sm text-white/90">
                <span id="modalAuthor"></span>
                <span id="modalAdminBadge" class="hidden px-2 py-0.5 text-xs font-semibold bg-white/25 rounded-full">✓ Pentadbir Sistem</span>
                <span id="modalDate" class="text-white/75 text-xs"></span>
            </div>
        </div>
        {{-- Modal Body --}}
        <div class="overflow-y-auto flex-1 p-6">
            <div id="modalBody" class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line"></div>
            {{-- Stats --}}
            <div id="modalStats" class="hidden mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-center gap-8 text-center">
                <div>
                    <p id="modalViewCount" class="text-2xl font-bold text-blue-600">0</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total Tontonan</p>
                </div>
                <div>
                    <p id="modalReadersCount" class="text-2xl font-bold text-green-600">0</p>
                    <p class="text-xs text-gray-400 mt-0.5">Staff Membaca</p>
                </div>
            </div>
        </div>
        {{-- Modal Footer --}}
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
    var loginType = document.getElementById('login_type');
    var loginId = document.getElementById('login_id');
    var loginLabel = document.getElementById('login_label');
    var tabStaff = document.getElementById('tab-staff');
    var tabParent = document.getElementById('tab-parent');

    loginType.value = type;

    var activeClass = ['bg-white', 'dark:bg-gray-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm'];
    var inactiveClass = ['text-gray-500', 'dark:text-gray-400'];

    if (type === 'staff') {
        loginLabel.textContent = 'Alamat Emel';
        loginId.type = 'email';
        activeClass.forEach(c => tabStaff.classList.add(c));
        inactiveClass.forEach(c => tabStaff.classList.remove(c));
        inactiveClass.forEach(c => tabParent.classList.add(c));
        activeClass.forEach(c => tabParent.classList.remove(c));
    } else {
        loginLabel.textContent = 'No. Kad Pengenalan Ibu/Bapa';
        loginId.type = 'text';
        activeClass.forEach(c => tabParent.classList.add(c));
        inactiveClass.forEach(c => tabParent.classList.remove(c));
        inactiveClass.forEach(c => tabStaff.classList.add(c));
        activeClass.forEach(c => tabStaff.classList.remove(c));
    }
}

function togglePassword() {
    var field = document.getElementById('password-field');
    var iconEye = document.getElementById('icon-eye');
    var iconOff = document.getElementById('icon-eye-off');
    if (field.type === 'password') {
        field.type = 'text';
        iconEye.classList.add('hidden');
        iconOff.classList.remove('hidden');
    } else {
        field.type = 'password';
        iconEye.classList.remove('hidden');
        iconOff.classList.add('hidden');
    }
}

function showAnnouncementModal(announcementId) {
    var dataDiv = document.getElementById('announcement-data-' + announcementId);
    var title = dataDiv.getAttribute('data-title');
    var author = dataDiv.getAttribute('data-author');
    var isAdmin = dataDiv.getAttribute('data-is-admin') === '1';
    var date = dataDiv.getAttribute('data-date');
    var label = dataDiv.getAttribute('data-label');
    var viewCount = parseInt(dataDiv.getAttribute('data-view-count')) || 0;
    var readersCount = dataDiv.getAttribute('data-readers-count');
    var annId = dataDiv.getAttribute('data-announcement-id');
    var content = dataDiv.innerHTML;

    var labelIcons = { 'Ciri Baharu': '🆕', 'Pembaikan': '🔧', 'Penyelenggaraan': '⚠️', 'Kritikal': '🚨', 'Pengumuman': '📢' };

    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalBody').innerHTML = content;
    document.getElementById('modalAuthor').textContent = '👤 ' + author;
    document.getElementById('modalDate').textContent = '📅 ' + date;
    document.getElementById('modalLabel').textContent = (labelIcons[label] || '📢') + ' ' + (label || 'Hebahan Umum');
    document.getElementById('modalViewCount').textContent = viewCount;
    document.getElementById('modalReadersCount').textContent = readersCount;
    document.getElementById('modalStats').classList.remove('hidden');

    var adminBadge = document.getElementById('modalAdminBadge');
    if (isAdmin) { adminBadge.classList.remove('hidden'); } else { adminBadge.classList.add('hidden'); }

    document.getElementById('announcementModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    // Increment view count
    fetch('/announcements/' + annId + '/increment-view', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    }).then(function(res) {
        if (res.ok) { document.getElementById('modalViewCount').textContent = viewCount + 1; }
    });
}

function closeAnnouncementModal() {
    document.getElementById('announcementModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Close modal on backdrop click
document.getElementById('announcementModal').addEventListener('click', function(e) {
    if (e.target === this) closeAnnouncementModal();
});

// Restore login type on validation failure
document.addEventListener('DOMContentLoaded', function() {
    var loginType = document.getElementById('login_type').value;
    if (loginType === 'parent') {
        switchLoginType('parent');
    }
});
</script>
@endsection
