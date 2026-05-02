@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
@endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">Pengurusan Pengguna</h4>
                            <a href="{{ route('users.create') }}" class="rbt-btn btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Tambah Pengguna</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(!empty($tabRoles))
                        {{-- ── Tab Peranan ── --}}
                        <div class="d-flex flex-wrap gap-2 mb--15">
                            <a href="{{ route('users.index', array_filter(['search' => $search])) }}"
                               class="rbt-btn btn-xs {{ $filterRole === 'semua' ? 'btn-gradient' : 'btn-border' }}">
                                Semua&nbsp;<span class="badge bg-light text-dark" style="font-size:10px;">{{ $roleCounts['semua'] }}</span>
                            </a>
                            @foreach($tabRoles as $tabRole)
                            @php
                                $shortLabel = [
                                    'Pentadbir'   => 'Pentadbir',
                                    'Penyelia KAFA' => 'Penyelia',
                                    'Guru Besar'  => 'Guru Besar',
                                    'Guru KAFA'   => 'Guru KAFA',
                                    'Pembekal'    => 'Pembekal',
                                    'Ibu Bapa'    => 'Ibu Bapa',
                                ][$tabRole] ?? $tabRole;
                            @endphp
                            <a href="{{ route('users.index', array_filter(['role' => $tabRole, 'search' => $search])) }}"
                               class="rbt-btn btn-xs {{ $filterRole === $tabRole ? 'btn-gradient' : 'btn-border' }}">
                                {{ $shortLabel }}&nbsp;<span class="badge bg-light text-dark" style="font-size:10px;">{{ $roleCounts[$tabRole] }}</span>
                            </a>
                            @endforeach
                        </div>

                        {{-- ── Search Bar ── --}}
                        <form method="GET" class="d-flex gap-2 mb--20">
                            @if($filterRole !== 'semua')
                                <input type="hidden" name="role" value="{{ $filterRole }}">
                            @endif
                            <input type="text" name="search" value="{{ $search }}"
                                   class="form-control form-control-sm"
                                   placeholder="Cari nama atau emel..."
                                   style="max-width:280px;">
                            <button type="submit" class="rbt-btn btn-border btn-sm">
                                <i class="feather-search me-1"></i>Cari
                            </button>
                            @if($search || $filterRole !== 'semua')
                            <a href="{{ route('users.index') }}" class="rbt-btn btn-sm" style="background:#f0f0f0;color:#555;">
                                <i class="feather-x"></i>
                            </a>
                            @endif
                        </form>
                        @endif

                        {{-- ── Jadual ── --}}
                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Sekolah / Skop</th>
                                        <th>Peranan</th>
                                        <th style="width:90px;" class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $i => $user)
                                    <tr id="row-{{ $user->id }}">
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <strong style="font-size:13px;">{{ $user->name }}</strong><br>
                                            <small class="text-muted" style="font-size:11px;">{{ $user->email }}</small>
                                        </td>
                                        <td>
                                            @if($user->school_id)
                                                <span class="rbt-badge-5 bg-secondary-opacity" style="font-size:0.75em;">{{ $user->school->name ?? '-' }}</span>
                                            @elseif($user->hasRole('Ibu Bapa'))
                                                <span class="rbt-badge-5 bg-success-opacity color-success" style="font-size:0.75em;">Ibu Bapa / Penjaga</span>
                                            @elseif($user->hasRole('Pembekal'))
                                                <span class="rbt-badge-5 bg-warning-opacity color-warning" style="font-size:0.75em;">Pembekal APKM</span>
                                            @elseif($user->hasAnyRole(['Super Admin', 'Pentadbir']))
                                                <span class="rbt-badge-5 bg-primary-opacity color-primary" style="font-size:0.75em;">Pejabat Agama</span>
                                            @elseif($user->district_id && !$user->school_id)
                                                <span class="rbt-badge-5 bg-info-opacity" style="font-size:0.75em;">{{ $user->district->name ?? 'Daerah' }}</span>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="rbt-badge-5 bg-primary-opacity" style="font-size:0.75em;">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <a href="{{ route('users.edit', $user) }}" class="rbt-btn btn-xs btn-border-gradient" title="Edit"
                                                   style="height:32px;width:32px;padding:0;display:flex;align-items:center;justify-content:center;">
                                                    <i class="feather-edit" style="font-size:13px;"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                      data-delete-form data-name="{{ $user->name }}" style="margin:0;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger" title="Padam"
                                                            style="height:32px;width:32px;padding:0;display:flex;align-items:center;justify-content:center;">
                                                        <i class="feather-trash-2" style="font-size:13px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted p-4">
                                            <i class="feather-users me-2"></i>
                                            @if($search)
                                                Tiada pengguna sepadan dengan carian "<strong>{{ $search }}</strong>".
                                            @else
                                                Tiada pengguna dalam kategori ini.
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--20 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Jumlah: {{ $users->total() }} pengguna
                                @if($filterRole !== 'semua') dalam tab <strong>{{ $filterRole }}</strong>@endif
                                @if($search) · carian "<strong>{{ $search }}</strong>"@endif
                            </small>
                            {{ $users->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
