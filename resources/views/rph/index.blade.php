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
                        <div class="section-title d-flex justify-content-between align-items-center flex-wrap gap--10">
                            <h4 class="rbt-title-style-3">Rekod Pengajaran Harian (RPH)</h4>
                            @role('Guru KAFA|Penyelia KAFA|Super Admin|Pentadbir|Guru Besar')
                            <a href="{{ route('rph.create') }}" class="rbt-btn btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Cipta RPH Baru</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                            @endrole
                        </div>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tarikh</th>
                                        <th>Hari</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Tajuk</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rphs as $rph)
                                    @php $p1 = $rph->periods->first(); @endphp
                                    <tr>
                                        <td>{{ ($rphs->currentPage() - 1) * $rphs->perPage() + $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</td>
                                        <td>{{ $rph->hari ?? '-' }}</td>
                                        <td class="jawi-cell">
                                            @if($rph->isGabungan())
                                                <span class="badge bg-info me-1">Gabungan</span>
                                                <small class="d-block text-muted">{{ $rph->getCombinedYearsLabel() }}</small>
                                                {{ $rph->mata_pelajaran ?? '-' }}
                                            @else
                                                {{ $p1?->mata_pelajaran_jawi ?? '-' }}
                                            @endif
                                        </td>
                                        <td class="jawi-cell">
                                            @if($rph->isGabungan())
                                                {{ $rph->topic ?? '-' }}
                                            @else
                                                {{ $p1?->topic_jawi ?? $rph->topic_jawi ?? '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($rph->status == 'pending')
                                                <span class="rbt-badge-5 bg-color-warning color-white">Menunggu Semakan</span>
                                            @elseif($rph->status == 'approved')
                                                <span class="rbt-badge-5 bg-color-success color-white">Diluluskan</span>
                                            @elseif($rph->status == 'rejected')
                                                <span class="rbt-badge-5 bg-color-danger color-white">Ditolak</span>
                                            @elseif($rph->status == 'revision_needed')
                                                <span class="rbt-badge-5 bg-color-primary color-white">Perlu Pembaikan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- Lihat --}}
                                                <a href="{{ route('rph.show', $rph) }}"
                                                   class="rbt-btn btn-sm btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   style="width:35px; height:35px; color:#007bff;"
                                                   title="Lihat Butiran">
                                                    <i class="feather-eye"></i>
                                                </a>

                                                {{-- Edit (hanya jika bukan approved & milik sendiri) --}}
                                                @if(auth()->id() == $rph->user_id && $rph->status != 'approved')
                                                <a href="{{ route('rph.edit', $rph) }}"
                                                   class="rbt-btn btn-sm btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   style="width:35px; height:35px; color:#28a745;"
                                                   title="Kemas Kini">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                @endif

                                                {{-- PDF (hanya jika approved) --}}
                                                @if($rph->status == 'approved')
                                                <button type="button"
                                                   onclick="openPdfBlob(this, '{{ route('rph.pdf', $rph) }}')"
                                                   class="rbt-btn btn-sm btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   style="width:35px; height:35px; color:#6c63ff; border:none; cursor:pointer;"
                                                   title="Cetak / Papar PDF">
                                                    <i class="feather-printer"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 color-body">Tiada draf RPH.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="row mt--20">
                            <div class="col-12">
                                {{ $rphs->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
    .jawi-cell { font-family:'Lateef',serif; font-size:1.1em; direction:rtl; text-align:right; }
</style>
@endsection
