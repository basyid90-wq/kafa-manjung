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
                        <div class="section-title">
                            @role('Guru Besar')
                            <h4 class="rbt-title-style-3">Semakan RPH Guru KAFA</h4>
                            @elserole('Penyelia KAFA')
                            <h4 class="rbt-title-style-3">Semakan RPH Guru Besar</h4>
                            @else
                            <h4 class="rbt-title-style-3">Kelulusan RPH</h4>
                            @endrole
                        </div>

                        <div class="mb--20">
                            <a href="{{ route('rph_approvals.history') }}" class="rbt-btn btn-sm btn-outline-primary">
                                <i class="feather-clock"></i> Lihat Sejarah Kelulusan
                            </a>
                        </div>

                        @if($records->isEmpty())
                        <div class="text-center py-5">
                            <i class="feather-check-circle" style="font-size:3rem; color:#2e7d32;"></i>
                            <h5 class="mt--15">Tiada RPH Menunggu Semakan</h5>
                            @role('Guru Besar')
                            <p class="color-body">Tiada RPH dari Guru KAFA yang perlu disemak.</p>
                            <p class="color-body mt-2"><small><i class="feather-info"></i> RPH yang anda hantar sendiri akan disemak oleh Penyelia KAFA.</small></p>
                            @else
                            <p class="color-body">Semua RPH guru telah disemak.</p>
                            @endrole
                        </div>
                        @else
                        <div class="row g-4 mt--10">
                            @foreach($records as $rph)
                            @php $p1 = $rph->periods->firstWhere('period_no', 1); @endphp
                            <div class="col-12">
                                <div style="border:1px solid #e8e8f0; border-radius:12px; overflow:hidden;">

                                    {{-- Card Header --}}
                                    <div style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 100%); padding:16px 20px; color:white;">

                                        {{-- Baris 1: Status badge + bilangan waktu --}}
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="rbt-badge-5 bg-color-warning color-white">
                                                <i class="feather-clock" style="font-size:0.75em; vertical-align:middle;"></i>
                                                Menunggu Semakan
                                            </span>
                                            <small style="opacity:0.6; font-size:0.78em;">
                                                <i class="feather-layers" style="font-size:0.85em;"></i>
                                                {{ $rph->periods->count() }} waktu
                                            </small>
                                        </div>

                                        {{-- Tajuk & Mata Pelajaran (Jawi) --}}
                                        @if($p1?->topic_jawi)
                                        <p class="mb-1" style="font-family:'Lateef',serif; font-size:1.4em; direction:rtl; text-align:right; line-height:1.5;">{{ $p1->topic_jawi }}</p>
                                        @else
                                        <p class="mb-1" style="opacity:0.6; font-size:0.88em;">— tiada tajuk —</p>
                                        @endif
                                        @if($p1?->mata_pelajaran_jawi)
                                        <p class="mb-2" style="font-family:'Lateef',serif; font-size:1em; opacity:0.8; direction:rtl; text-align:right;">{{ $p1->mata_pelajaran_jawi }}</p>
                                        @endif

                                        {{-- Baris 2: Guru + Sekolah --}}
                                        <div class="row g-2 mt-1">
                                            <div class="{{ auth()->user()->hasAnyRole(['Penyelia KAFA','Super Admin','Pentadbir']) ? 'col-md-6' : 'col-12' }}">
                                                <div style="background:rgba(255,255,255,0.1); border-radius:8px; padding:8px 12px;">
                                                    <div style="font-size:0.68em; opacity:0.65; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:2px;">Guru</div>
                                                    <div style="font-weight:700; font-size:1em;">
                                                        <i class="feather-user" style="font-size:0.85em;"></i>
                                                        {{ $rph->user->name ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                            @hasanyrole('Penyelia KAFA|Super Admin|Pentadbir|Guru Besar')
                                            <div class="col-md-6">
                                                <div style="background:rgba(255,255,255,0.1); border-radius:8px; padding:8px 12px;">
                                                    <div style="font-size:0.68em; opacity:0.65; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:2px;">Sekolah</div>
                                                    <div style="font-weight:600; font-size:0.9em; line-height:1.3;">
                                                        <i class="feather-home" style="font-size:0.85em;"></i>
                                                        {{ $rph->school->name ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                            @endhasanyrole
                                        </div>

                                        {{-- Baris 3: Kelas | Tarikh & Hari | Minggu | Masa --}}
                                        <div class="d-flex flex-wrap gap-2 mt-2" style="font-size:0.82em;">
                                            <span style="background:rgba(255,255,255,0.15); padding:3px 10px; border-radius:20px;">
                                                <i class="feather-book" style="font-size:0.85em;"></i>
                                                {{ $p1?->kafaClass?->name ?? $rph->kafaClass?->name ?? '-' }}
                                            </span>
                                            <span style="background:rgba(255,255,255,0.15); padding:3px 10px; border-radius:20px;">
                                                <i class="feather-calendar" style="font-size:0.85em;"></i>
                                                {{ $rph->hari ?? '' }} {{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}
                                            </span>
                                            <span style="background:rgba(255,255,255,0.15); padding:3px 10px; border-radius:20px;">
                                                <i class="feather-hash" style="font-size:0.85em;"></i>
                                                Minggu {{ $rph->week }}
                                            </span>
                                            @if($p1?->masa)
                                            <span style="background:rgba(255,255,255,0.15); padding:3px 10px; border-radius:20px;">
                                                <i class="feather-clock" style="font-size:0.85em;"></i>
                                                {{ $p1->masa }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Kandungan Ringkas (Waktu 1) --}}
                                    <div style="padding:16px 20px;">
                                        @if($p1)
                                        <p style="font-size:0.8em; font-weight:700; text-transform:uppercase; color:var(--color-primary); margin-bottom:10px;">Waktu 1 — Pratonton</p>
                                        <div class="row g-3">
                                            @foreach([
                                                ['كماهيرن', $p1->kemahiran_jawi],
                                                ['اوبجيكتيف', $p1->objective_jawi],
                                                ['اكتيۏيتي', $p1->aktiviti_jawi],
                                                ['ايمڤک', $p1->reflection_jawi],
                                            ] as [$lbl, $val])
                                            @if($val)
                                            <div class="col-md-6">
                                                <p class="mb--3" style="font-family:'Lateef',serif; font-size:1em; direction:rtl; text-align:right; color:var(--color-primary);">{{ $lbl }}</p>
                                                <p class="mb--0" style="background:#f0f4ff; padding:8px 12px; border-radius:8px; font-family:'Lateef',serif; font-size:1.1em; text-align:right; direction:rtl; white-space:pre-wrap;">{{ $val }}</p>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        @endif

                                        {{-- Lihat butiran --}}
                                        <div class="mt--15">
                                            <a href="{{ route('rph.show', $rph) }}" class="rbt-btn btn-sm btn-border-gradient" style="font-size:0.82em;">
                                                <i class="feather-eye"></i> Lihat Semua Waktu
                                            </a>
                                        </div>

                                        {{-- Form Keputusan --}}
                                        @hasanyrole('Penyelia KAFA|Super Admin|Pentadbir|Guru Besar')
                                        <hr class="mt--20 mb--20">
                                        <form action="{{ route('rph_approvals.update', $rph) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-4">
                                                    <div class="rbt-form-group">
                                                        <label style="font-size:0.88em; font-weight:700;">Keputusan <span class="text-danger">*</span></label>
                                                        <select name="status" class="rbt-big-select" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="approved">✅ Luluskan</option>
                                                            <option value="revision_needed">🔄 Perlu Pembaikan</option>
                                                            <option value="rejected">❌ Tolak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rbt-form-group">
                                                        <label style="font-size:0.88em; font-weight:700;">Ulasan (jika ada)</label>
                                                        <textarea name="review_comment" rows="2"
                                                            style="border:1px solid #ddd; border-radius:8px; padding:10px 14px; width:100%; font-size:0.88em; resize:vertical;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="rbt-btn btn-gradient btn-sm w-100">
                                                        <i class="feather-send"></i> Hantar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        @else
                                        <div class="mt--15 p-3" style="background:#f0f4ff; border-radius:8px; border-left:3px solid #6c63ff; font-size:0.85em; color:#555;">
                                            <i class="feather-info"></i> Anda dalam mod <strong>baca sahaja</strong>. Kelulusan RPH dilakukan oleh Penyelia KAFA.
                                        </div>
                                        @endhasanyrole
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Pagination --}}
                        @if($records->hasPages())
                        <div class="row mt--30">
                            <div class="col-12">
                                {{ $records->links() }}
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
</style>
@endsection
