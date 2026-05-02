@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Pengurusan Pengguna</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Senarai semua pengguna sistem mengikut peranan</p>
        </div>
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengguna
        </a>
    </div>

    {{-- ── Role Tabs ── --}}
    @if(!empty($tabRoles))
    <div class="flex flex-wrap gap-2 mb-4">
        @php
        $tabLabel = [
            'semua'         => 'Semua',
            'Pentadbir'     => 'Pentadbir',
            'Penyelia KAFA' => 'Penyelia',
            'Guru Besar'    => 'Guru Besar',
            'Guru KAFA'     => 'Guru KAFA',
            'Pembekal'      => 'Pembekal',
            'Ibu Bapa'      => 'Ibu Bapa',
        ];
        $tabColor = [
            'semua'         => 'blue',
            'Pentadbir'     => 'purple',
            'Penyelia KAFA' => 'indigo',
            'Guru Besar'    => 'pink',
            'Guru KAFA'     => 'green',
            'Pembekal'      => 'yellow',
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
                     : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            {{ $label }}
            <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full text-[10px] font-semibold
                         {{ $active ? 'bg-white/25 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300' }}">
                {{ $count }}
            </span>
        </a>
        @endforeach
    </div>
    @endif

    {{-- ── Main Card ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

        {{-- ── Search Bar ── --}}
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
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
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <button type="submit"
                        class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors">
                    Cari
                </button>
                @if($search || $filterRole !== 'semua')
                <a href="{{ route('users.index') }}"
                   class="px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-sm rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
                @endif
                <p class="ml-auto text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                    {{ $users->total() }} pengguna
                    @if($filterRole !== 'semua') · <span class="font-medium">{{ $filterRole }}</span>@endif
                    @if($search) · "<span class="font-medium">{{ $search }}</span>"@endif
                </p>
            </form>
        </div>

        {{-- ── Table ── --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Skop / Sekolah</th>
                        <th class="px-5 py-3">Peranan</th>
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($users as $i => $user)
                    @php
                        $initials = collect(explode(' ', $user->name))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                        $roleFirst = $user->roles->first()?->name ?? '';
                        $avatarColors = [
                            'Super Admin'   => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                            'Pentadbir'     => 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400',
                            'Penyelia KAFA' => 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400',
                            'Guru Besar'    => 'bg-pink-100 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400',
                            'Guru KAFA'     => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                            'Pembekal'      => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'Ibu Bapa'      => 'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400',
                        ];
                        $avatarClass = $avatarColors[$roleFirst] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300';
                        $roleBadgeColors = [
                            'Super Admin'   => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            'Pentadbir'     => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                            'Penyelia KAFA' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                            'Guru Besar'    => 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400',
                            'Guru KAFA'     => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'Pembekal'      => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'Ibu Bapa'      => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                        ];
                    @endphp
                    <tr id="row-{{ $user->id }}" class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $avatarClass }} flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            @if($user->school_id)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                    {{ $user->school->name ?? '—' }}
                                </span>
                            @elseif($user->hasRole('Ibu Bapa'))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400">
                                    Ibu Bapa / Penjaga
                                </span>
                            @elseif($user->hasRole('Pembekal'))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    Pembekal APKM
                                </span>
                            @elseif($user->hasAnyRole(['Super Admin', 'Pentadbir']))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                    Pejabat Agama
                                </span>
                            @elseif($user->district_id && !$user->school_id)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                    {{ $user->district->name ?? 'Daerah' }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeColors[$role->name] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Padam pengguna {{ addslashes($user->name) }}? Tindakan ini tidak boleh dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors"
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
                                    <p class="text-sm">Tiada pengguna sepadan dengan carian "<strong class="text-gray-600 dark:text-gray-300">{{ $search }}</strong>"</p>
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
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
