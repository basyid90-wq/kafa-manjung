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

                        {{-- Ucapan selamat datang --}}
                        <div class="section-title d-flex justify-content-between align-items-center mb--30 flex-wrap gap-2">
                            <div>
                                <h4 class="rbt-title-style-3">Portal Ibu Bapa / Penjaga</h4>
                                <p class="color-body mb-0" style="font-size:0.9em;">
                                    Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
                                    Berikut adalah maklumat anak-anak anda.
                                </p>
                            </div>
                            <span class="rbt-badge-5 bg-primary-opacity color-primary" style="font-size:0.82em;">
                                <i class="feather-users me-1"></i>
                                {{ $children->count() }} anak didaftarkan
                            </span>
                        </div>

                        @if($children->isEmpty())
                            {{-- Empty State --}}
                            <div class="text-center py-5">
                                <div style="width:90px; height:90px; border-radius:50%; background:rgba(108,99,255,0.08);
                                            display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
                                    <i class="feather-alert-circle" style="font-size:2.5rem; color:#6c63ff;"></i>
                                </div>
                                <h5 class="mb--10">Tiada Rekod Anak Dijumpai</h5>
                                <p class="color-body" style="max-width:480px; margin:0 auto; font-size:0.9em; line-height:1.7;">
                                    Sistem tidak dapat mengesan anak-anak yang dikaitkan dengan No. Kad Pengenalan anda
                                    (<strong>{{ auth()->user()->ic_number ?? '—' }}</strong>).
                                    Sila pastikan pihak sekolah telah mendaftarkan Nombor Kad Pengenalan anda
                                    dengan tepat dalam profil murid.
                                </p>
                                <div class="mt--30">
                                    <a href="{{ route('announcements.index') }}"
                                       class="rbt-btn btn-border-gradient btn-sm">
                                        <i class="feather-bell me-1"></i> Lihat Hebahan
                                    </a>
                                </div>
                            </div>

                        @else
                            {{-- Profile Cards Grid --}}
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                @foreach($children as $child)
                                <div class="col">
                                    <div class="rbt-shadow-box h-100 p--20 d-flex flex-column"
                                         style="border-radius:12px; border:1px solid #eef0f8;">

                                        {{-- Gambar Profil --}}
                                        <div class="text-center mb--20">
                                            @if($child->profile_picture)
                                                <img src="{{ asset('storage/' . $child->profile_picture) }}"
                                                     alt="{{ $child->name }}"
                                                     style="width:90px; height:90px; object-fit:cover;
                                                            border-radius:50%; border:3px solid #eef0f8;">
                                            @else
                                                <div style="width:90px; height:90px; border-radius:50%;
                                                            background:linear-gradient(135deg,#1a1a2e,#6c63ff);
                                                            display:flex; align-items:center; justify-content:center;
                                                            margin:0 auto; font-size:2rem; color:white; font-weight:700;">
                                                    {{ strtoupper(mb_substr($child->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Maklumat Murid --}}
                                        <div class="text-center mb--15">
                                            <h6 class="mb-1" style="font-size:0.95em; font-weight:700; line-height:1.4;">
                                                {{ $child->name }}
                                            </h6>
                                            @if($child->jawi_name)
                                            <p class="mb-1 color-body" dir="rtl"
                                               style="font-family:'Lateef',serif; font-size:1.05em;">
                                                {{ $child->jawi_name }}
                                            </p>
                                            @endif
                                        </div>

                                        {{-- Badge Maklumat --}}
                                        <div class="d-flex flex-column gap-2 mb--20 flex-grow-1">

                                            <div class="d-flex align-items-center gap-2"
                                                 style="font-size:0.82em; color:#555;">
                                                <i class="feather-home" style="color:#6c63ff; flex-shrink:0;"></i>
                                                <span>{{ $child->school->name ?? '—' }}</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-2"
                                                 style="font-size:0.82em; color:#555;">
                                                <i class="feather-book" style="color:#6c63ff; flex-shrink:0;"></i>
                                                <span>{{ $child->kafaClass->display_name ?? '—' }}</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-2"
                                                 style="font-size:0.82em; color:#555;">
                                                <i class="feather-credit-card" style="color:#6c63ff; flex-shrink:0;"></i>
                                                <span>{{ $child->mykid }}</span>
                                            </div>

                                            @php
                                                $statusColor = $child->status === 'Aktif' ? 'success' : 'warning';
                                            @endphp
                                            <div>
                                                <span class="rbt-badge-5 bg-{{ $statusColor }}-opacity color-{{ $statusColor }}"
                                                      style="font-size:0.75em;">
                                                    {{ $child->status ?? 'Aktif' }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Butang Tindakan --}}
                                        <div class="mt-auto pt--15" style="border-top:1px solid #eef0f8;">
                                            <a href="{{ route('parent.student.show', $child) }}"
                                               class="rbt-btn btn-gradient w-100 text-center"
                                               style="font-size:0.82em; padding:10px;">
                                                <i class="feather-user me-1"></i> Lihat Profil Penuh
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
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
