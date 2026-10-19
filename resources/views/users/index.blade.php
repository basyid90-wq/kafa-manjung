@extends('layout-fb.layout')

@section('content')
<div>

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Pengurusan Pengguna</h1>
            <p class="ek-page-sub mt-1">Senarai semua pengguna sistem mengikut peranan</p>
        </div>
        <div class="flex items-center gap-2">
        @if(auth()->user()->school_id)
        <button type="button" onclick="document.getElementById('inviteModal').classList.remove('hidden')"
                class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Jemput Guru
        </button>
        @endif
        <a href="{{ route('users.create') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengguna
        </a>
        </div>
    </div>

    {{-- ── Jemputan belum diterima ── --}}
    @if($invitations->isNotEmpty())
    <div class="ek-table-wrap mb-6">
        <div class="px-5 py-3 border-b border-gray-200">
            <h2 class="text-sm font-semibold text-gray-900">Jemputan Belum Diterima</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 text-left w-12">No</th>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-left">E-mel</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invitations as $inv)
                    <tr>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3 text-gray-900">{{ $inv->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $inv->email }}</td>
                        <td class="px-5 py-3">
                            @if($inv->isPending())
                            <span class="ek-badge ek-badge-yellow">Menunggu (hingga {{ $inv->expires_at->format('d/m/Y') }})</span>
                            @else
                            <span class="ek-badge ek-badge-gray">Tamat tempoh</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center">
                                <form action="{{ route('invitations.destroy', $inv) }}" method="POST" data-delete-form data-name="jemputan {{ $inv->email }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Batal Jemputan"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── Modal: Jemput Guru ── --}}
    <div id="inviteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
            <form action="{{ route('invitations.store') }}" method="POST">
                @csrf
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Jemput Guru KAFA</h3>
                    <p class="text-sm text-gray-500">Guru akan menerima e-mel untuk mencipta kata laluan sendiri. Jika guru sudah ada akaun Personal, data kelasnya akan digabungkan ke sekolah ini.</p>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="ek-label">Nama Guru <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required maxlength="255"
                               class="ek-input">
                    </div>
                    <div>
                        <label class="ek-label">E-mel Guru <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required maxlength="255"
                               class="ek-input">
                    </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('inviteModal').classList.add('hidden')"
                            class="ek-btn-secondary">Batal</button>
                    <button type="submit"
                            class="ek-btn-primary">Hantar Jemputan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Role Tabs ── --}}
    @if(!empty($tabRoles))
    <div class="flex flex-wrap gap-2 mb-4">
        @php
        $tabLabel = [
            'semua'         => 'Semua',
            'Guru Besar'    => 'Guru Besar',
            'Guru KAFA'     => 'Guru KAFA',
            'Ibu Bapa'      => 'Ibu Bapa',
        ];
        $tabColor = [
            'semua'         => 'blue',
            'Guru Besar'    => 'pink',
            'Guru KAFA'     => 'green',
            'Ibu Bapa'      => 'orange',
        ];
        $allTabs = array_merge(['semua'], $tabRoles);
        @endphp
        @foreach($allTabs as $tab)
        @php
            $active  = $filterRole === $tab;
            $label   = $tabLabel[$tab] ?? $tab;
            $count   = $roleCounts[$tab] ?? 0;
            $color   = $tabColor[$tab] ?? 'gray';
            $href    = route('users.index', array_filter(['role' => $tab === 'semua' ? null : $tab, 'search' => $search]));
        @endphp
        <a href="{{ $href }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border transition-colors
                  {{ $active
                     ? 'bg-'.$color.'-600 text-white border-'.$color.'-600'
                     : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
            {{ $label }}
            <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full text-[10px] font-semibold
                         {{ $active ? 'bg-white/25 text-white' : 'bg-gray-100 text-gray-600' }}">
                {{ $count }}
            </span>
        </a>
        @endforeach
    </div>
    @endif

    {{-- ── Main Card ── --}}
    <div class="ek-table-wrap">

        {{-- ── Search Bar ── --}}
        <div class="px-5 py-4 border-b border-gray-200">
            <form method="GET" class="flex items-center gap-2">
                @if($filterRole !== 'semua')
                    <input type="hidden" name="role" value="{{ $filterRole }}">
                @endif
                <div class="relative flex-1 max-w-xs">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari nama atau emel..."
                           class="ek-input pl-9 pr-3 placeholder-gray-400">
                </div>
                <button type="submit"
                        class="ek-btn-primary">
                    Cari
                </button>
                @if($search || $filterRole !== 'semua')
                <a href="{{ route('users.index') }}"
                   class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
                @endif
                <p class="ml-auto text-xs text-gray-500 whitespace-nowrap">
                    {{ $users->total() }} pengguna
                    @if($filterRole !== 'semua') · <span class="font-medium">{{ $filterRole }}</span>@endif
                    @if($search) · "<span class="font-medium">{{ $search }}</span>"@endif
                </p>
            </form>
        </div>

        {{-- ── Table ── --}}
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Skop / Sekolah</th>
                        <th class="px-5 py-3">Peranan</th>
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    @php
                        $initials = collect(explode(' ', $user->name))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                        $roleFirst = $user->roles->first()?->name ?? '';
                        $avatarColors = [
                            'Super Admin'   => 'bg-red-100 text-red-600',
                            'Guru Besar'    => 'bg-pink-100 text-pink-600',
                            'Guru KAFA'     => 'bg-green-100 text-green-600',
                            'Ibu Bapa'      => 'bg-orange-100 text-orange-600',
                        ];
                        $avatarClass = $avatarColors[$roleFirst] ?? 'bg-gray-100 text-gray-600';
                        $roleBadgeColors = [
                            'Super Admin'   => 'bg-red-100 text-red-700',
                            'Guru Besar'    => 'bg-pink-100 text-pink-700',
                            'Guru KAFA'     => 'bg-green-100 text-green-700',
                            'Ibu Bapa'      => 'bg-orange-100 text-orange-700',
                        ];
                    @endphp
                    <tr id="row-{{ $user->id }}">
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $avatarClass }} flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            @if($user->school_id)
                                <span class="ek-badge ek-badge-gray">
                                    {{ $user->school->name ?? '—' }}
                                </span>
                            @elseif($user->hasRole('Ibu Bapa'))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                    Ibu Bapa / Penjaga
                                </span>
                            @elseif($user->hasRole('Super Admin'))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                    Pentadbir Platform
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeColors[$role->name] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                      data-delete-form data-name="pengguna {{ $user->name }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Padam">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                @if($search)
                                    <p class="text-sm">Tiada pengguna sepadan dengan carian "<strong class="text-gray-600">{{ $search }}</strong>"</p>
                                @else
                                    <p class="text-sm">Tiada pengguna dalam kategori ini.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($users->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
