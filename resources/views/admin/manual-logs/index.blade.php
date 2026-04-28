@extends('layout.layout')

@php $bodyClass = ''; $footer = 'true'; @endphp

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
                        <div class="section-title mb--30">
                            <h4 class="rbt-title-style-3">Log Muat Turun Panduan Pengguna</h4>
                            <p class="color-body" style="font-size:0.88em;">
                                Rekod setiap kali pengguna memuat turun Buku Panduan. Jumlah: <strong>{{ $logs->total() }}</strong> rekod.
                            </p>
                        </div>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pengguna</th>
                                        <th>Peranan</th>
                                        <th>Sekolah</th>
                                        <th>Tarikh Muat Turun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $i => $log)
                                    <tr>
                                        <td>{{ $logs->firstItem() + $i }}</td>
                                        <td>
                                            <strong>{{ $log->user->name ?? '—' }}</strong>
                                            <div class="color-body" style="font-size:0.78em;">
                                                {{ $log->user->email ?? '' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="rbt-badge-5 bg-primary-opacity color-primary" style="font-size:0.78em;">
                                                {{ $log->role_name }}
                                            </span>
                                        </td>
                                        <td class="color-body" style="font-size:0.85em;">
                                            {{ $log->school->name ?? '—' }}
                                        </td>
                                        <td class="color-body" style="font-size:0.85em;">
                                            {{ $log->downloaded_at?->format('d/m/Y H:i') ?? '—' }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center color-body">Tiada rekod muat turun.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt--20">{{ $logs->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
