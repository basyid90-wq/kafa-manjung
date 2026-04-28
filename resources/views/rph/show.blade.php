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
                        <div class="section-title d-flex justify-content-between align-items-center flex-wrap gap--10">
                            <h4 class="rbt-title-style-3">Butiran RPH</h4>
                            <div class="d-flex gap--10 flex-wrap">
                                @if($rph->status == 'approved')
                                <button type="button"
                                    onclick="openPdfBlob(this, '{{ route('rph.pdf', $rph) }}')"
                                    class="rbt-btn btn-sm btn-gradient"
                                    style="border:none; cursor:pointer;">
                                    <i class="feather-file-text"></i> Cetak / Papar PDF
                                </button>
                                @endif
                                @if($rph->user_id == auth()->id() && $rph->status != 'approved')
                                <a href="{{ route('rph.edit', $rph) }}" class="rbt-btn btn-sm btn-border-gradient">
                                    <i class="feather-edit-2"></i> Kemas Kini
                                </a>
                                @endif
                                <a href="{{ route('rph.index') }}" class="rbt-btn btn-sm btn-border">
                                    <i class="feather-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>

                        {{-- Status Banner --}}
                        @if($rph->status == 'revision_needed' && $rph->review_comment)
                        <div class="alert alert-warning mt--20" style="border-left:4px solid #f9a825; padding:16px 20px; border-radius:8px; background:#fff8e1;">
                            <strong><i class="feather-alert-circle"></i> Perlukan Pembaikan</strong>
                            <p class="mt--10 mb--0">{{ $rph->review_comment }}</p>
                        </div>
                        @elseif($rph->status == 'rejected' && $rph->review_comment)
                        <div class="alert alert-danger mt--20" style="border-left:4px solid #e53935; padding:16px 20px; border-radius:8px; background:#ffebee;">
                            <strong><i class="feather-x-circle"></i> RPH Ditolak</strong>
                            <p class="mt--10 mb--0">{{ $rph->review_comment }}</p>
                        </div>
                        @elseif($rph->status == 'approved')
                        <div class="alert alert-success mt--20" style="border-left:4px solid #2e7d32; padding:16px 20px; border-radius:8px; background:#e8f5e9;">
                            <strong><i class="feather-check-circle"></i> RPH Telah Diluluskan</strong>
                            @if($rph->reviewer)<p class="mt--5 mb--0">Oleh: {{ $rph->reviewer->name }}</p>@endif
                        </div>
                        @endif

                        {{-- A. Maklumat Am --}}
                        <div class="rph-section-header mt--30">A. Maklumat Am</div>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <div class="rph-info-cell">
                                    <small>Tarikh</small>
                                    <strong>{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="rph-info-cell">
                                    <small>Hari</small>
                                    <strong>{{ $rph->hari ?? '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="rph-info-cell">
                                    <small>Minggu</small>
                                    <strong>{{ $rph->week }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="rph-info-cell">
                                    <small>Guru</small>
                                    <strong>{{ $rph->user->name ?? '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="rph-info-cell">
                                    <small>Status</small>
                                    @if($rph->status == 'pending')
                                        <span class="rbt-badge-5 bg-color-warning color-white">Menunggu Semakan</span>
                                    @elseif($rph->status == 'approved')
                                        <span class="rbt-badge-5 bg-color-success color-white">Diluluskan</span>
                                    @elseif($rph->status == 'rejected')
                                        <span class="rbt-badge-5 bg-color-danger color-white">Ditolak</span>
                                    @elseif($rph->status == 'revision_needed')
                                        <span class="rbt-badge-5 bg-color-primary color-white">Perlu Pembaikan</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- B. Kandungan — per waktu --}}
                        <div class="rph-section-header mt--30">B. Kandungan Pengajaran</div>

                        @forelse($rph->periods as $period)
                        <div class="rph-period-card mt--20">
                            <div class="rph-period-no">Waktu {{ $period->period_no }}</div>
                            <div class="row g-3 mt--5">
                                <div class="col-md-4 col-6">
                                    <div class="rph-info-cell">
                                        <small>Kelas</small>
                                        <strong>{{ $period->kafaClass->display_name ?? '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="rph-info-cell">
                                        <small>Masa</small>
                                        <strong>{{ $period->masa ?? '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="rph-info-cell">
                                        <small>Mata Pelajaran</small>
                                        <strong class="jawi-text">{{ $period->mata_pelajaran_jawi ?? '-' }}</strong>
                                    </div>
                                </div>
                            </div>

                            @php
                                $fields = [
                                    ['تاجوق ڤلاجرن',       $period->topic_jawi],
                                    ['كماهيرن',             $period->kemahiran_jawi],
                                    ['ايسي ڤلاجرن',         $period->isi_pelajaran_jawi],
                                    ['اوبجيكتيف ڤمبلاجرن',  $period->objective_jawi],
                                    ['اكتيۏيتي ڤ&ڤ',        $period->aktiviti_jawi],
                                    ['ايمڤک ڤمبلاجرن',      $period->reflection_jawi],
                                ];
                            @endphp

                            @foreach($fields as [$label, $value])
                            <div class="rph-field-view mt--10">
                                <div class="rph-field-title jawi-label">{!! $label !!}</div>
                                <div class="rph-text-box jawi-text" dir="rtl">{{ $value ?: '—' }}</div>
                            </div>
                            @endforeach
                        </div>
                        @empty
                        <p class="color-body mt--20">Tiada data waktu pengajaran.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
    .rph-section-header { background:linear-gradient(135deg,#1a1a2e 0%,#16213e 100%); color:white; padding:10px 16px; border-radius:8px; font-weight:600; font-size:0.9em; margin-bottom:16px; }
    .rph-info-cell { background:#f8f9fe; padding:10px 14px; border-radius:8px; border:1px solid #eef0f8; }
    .rph-info-cell small { display:block; color:#999; font-size:0.78em; margin-bottom:2px; }
    .rph-info-cell strong { font-size:0.95em; color:#1a1a2e; }
    .rph-period-card { border:1px solid #e0e4f8; border-radius:12px; padding:18px; background:#fafbff; }
    .rph-period-no { font-weight:700; font-size:0.82em; text-transform:uppercase; color:var(--color-primary); letter-spacing:0.5px; }
    .rph-field-view { border:1px solid #eef0f8; border-radius:8px; padding:12px 14px; background:#fff; }
    .rph-field-title { font-size:1em; direction:rtl; text-align:right; color:var(--color-primary); margin-bottom:6px; }
    .rph-text-box { min-height:36px; font-size:0.92em; white-space:pre-wrap; color:#333; }
    .jawi-text { font-family:'Lateef',serif !important; font-size:1.2em !important; direction:rtl; text-align:right; display:block; }
    .jawi-label { font-family:'Lateef',serif; font-size:1.1em; direction:rtl; text-align:right; display:block; margin-bottom:4px; }
</style>
@endsection
