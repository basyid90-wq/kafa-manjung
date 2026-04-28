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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Pengurusan Pengguna</h4>
                            <a href="{{ route('users.create') }}" class="rbt-btn btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Tambah Pengguna</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                        </div>

                        <div class="table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Sekolah</th>
                                        <th>Peranan</th>
                                        <th style="width: 120px;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            @if($user->school_id)
                                                <span class="rbt-badge-5 bg-secondary-opacity" style="font-size:0.78em;">
                                                    {{ $user->school->name }}
                                                </span>
                                            @elseif($user->hasRole('Ibu Bapa'))
                                                <span class="rbt-badge-5 bg-success-opacity color-success" style="font-size:0.78em;">
                                                    Ibu Bapa / Penjaga
                                                </span>
                                            @elseif($user->hasRole('Pembekal'))
                                                <span class="rbt-badge-5 bg-warning-opacity color-warning" style="font-size:0.78em;">
                                                    Pembekal APKM
                                                </span>
                                            @elseif($user->hasAnyRole(['Super Admin', 'Pentadbir']))
                                                <span class="rbt-badge-5 bg-primary-opacity color-primary" style="font-size:0.78em;">
                                                    Pejabat Agama Daerah
                                                </span>
                                            @elseif($user->district_id && $user->school_id === null)
                                                <span class="rbt-badge-5 bg-info-opacity" style="font-size:0.78em;">
                                                    {{ $user->district->name ?? 'Daerah' }}
                                                </span>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="rbt-badge-5 bg-primary-opacity">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('users.edit', $user) }}" class="rbt-btn btn-xs btn-border-gradient" title="Edit" style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                    <i class="feather-edit" style="font-size: 14px;"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                      data-delete-form data-name="{{ $user->name }}" style="margin: 0;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger" title="Padam" style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                        <i class="feather-trash-2" style="font-size: 14px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt--20">
                            <div class="col-lg-12">
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
