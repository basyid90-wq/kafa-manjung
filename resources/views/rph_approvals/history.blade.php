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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Sejarah Kelulusan RPH</h4>
                            <a href="{{ route('rph_approvals.index') }}" class="rbt-btn btn-sm btn-border-gradient">
                                <i class="feather-arrow-left"></i> Kembali
                            </a>
                        </div>

                        {{-- Search Form --}}
                        <div class="rbt-search-with-filter mb--30">
                            <form action="{{ route('rph_approvals.history') }}" method="GET" class="row g-3">
                                <div class="col-md-10">
                                    <div class="rbt-form-group">
                                        <input name="search" type="text" placeholder="Cari Nama Guru..." value="{{ request('search') }}" style="height: 50px; border: 1px solid #ddd; padding: 0 15px; border-radius: 6px; width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="rbt-btn btn-gradient btn-sm w-100" style="height: 50px;">
                                        <i class="feather-search"></i> Cari
                                    </button>
                                </div>
                            </form>
                        </div>

                        @if($records->isEmpty())
                        <div class="text-center py-5">
                            <i class="feather-database" style="font-size:3rem; color:#ccc;"></i>
                            <h5 class="mt--15">Tiada Sejarah Kelulusan</h5>
                            <p class="color-body">Belum ada RPH yang disemak atau memenuhi kriteria carian.</p>
                        </div>
                        @else
                        <div class="rbt-dashboard-table table-responsive mobile-table-750">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tarikh RPH</th>
                                        <th>Nama Guru</th>
                                        <th>Sekolah / Kelas</th>
                                        <th>Status</th>
                                        <th>Disemak Oleh</th>
                                        <th class="text-end">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $index => $rph)
                                    <tr id="row-{{ $rph->id }}">
                                        <th>{{ $records->firstItem() + $index }}</th>
                                        <td>
                                            <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</span><br>
                                            <small class="text-muted">{{ $rph->hari }}</small>
                                        </td>
                                        <td>{{ $rph->user->name ?? '-' }}</td>
                                        <td>
                                            <small class="d-block">{{ $rph->school->name ?? '-' }}</small>
                                            <small class="badge bg-light text-dark" style="font-weight: 500;">{{ $rph->kafaClass->display_name ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if($rph->status == 'approved')
                                                <span class="rbt-badge-5 bg-color-success-opacity color-success">Lulus</span>
                                            @elseif($rph->status == 'rejected')
                                                <span class="rbt-badge-5 bg-color-danger-opacity color-danger">Tolak</span>
                                            @elseif($rph->status == 'revision_needed')
                                                <span class="rbt-badge-5 bg-color-warning-opacity color-warning">Pembaikan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $rph->reviewer->name ?? 'Sistem' }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                {{-- Lihat PDF --}}
                                                <button onclick="openPdfBlob(this, '{{ route('rph.pdf', $rph) }}')" 
                                                        class="rbt-btn btn-xs btn-border-gradient" 
                                                        title="Cetak/Lihat PDF" 
                                                        style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                    <i class="feather-printer" style="font-size: 14px;"></i>
                                                </button>

                                                {{-- Batal Kelulusan (Revert) — hanya Super Admin/Pentadbir/Penyelia KAFA --}}
                                                @if(auth()->user()->hasAnyRole(['Super Admin','Pentadbir','Penyelia KAFA']) && (auth()->user()->hasRole('Super Admin') || auth()->id() == $rph->reviewer_id))
                                                <form action="{{ route('rph_approvals.revert', $rph) }}" method="POST" 
                                                      data-delete-form="true" 
                                                      data-name="Kelulusan RPH ({{ $rph->user->name }})"
                                                      class="m-0">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" 
                                                            class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger" 
                                                            title="Batal Kelulusan (Undo)" 
                                                            style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                        <i class="feather-rotate-ccw" style="font-size: 14px;"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if($records->hasPages())
                        <div class="row mt--30">
                            <div class="col-12">
                                {{ $records->links() }}
                            </div>
                        </div>
                        @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
