@extends('layout.layout')

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
                            <h4 class="rbt-title-style-3">Aktiviti & Program Sekolah</h4>
                            @role('Super Admin|Penyelia KAFA|Guru Besar|Guru KAFA')
                            <a href="{{ route('activities.create') }}" class="rbt-btn btn-gradient btn-sm">Daftar Aktiviti Baru</a>
                            @endrole
                        </div>

                        <div class="row g-5 mt--20">
                            @foreach($activities as $activity)
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-card variation-01 rbt-hover">
                                    <div class="rbt-card-img">
                                        @if($activity->photo_path)
                                            <img src="{{ asset('storage/' . $activity->photo_path) }}" alt="{{ $activity->name }}" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div style="height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                                <i class="feather-image" style="font-size: 3rem; color: #ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="rbt-card-body">
                                        <div class="d-flex align-items-start justify-content-between mb--5">
                                            <h5 class="rbt-card-title mb--0">{{ $activity->name }}</h5>
                                            <span class="badge bg-{{ $activity->tahap_badge }} ms-2" style="font-size:10px;white-space:nowrap;">{{ $activity->tahap_label }}</span>
                                        </div>
                                        <ul class="rbt-meta">
                                            <li><i class="feather-calendar"></i> {{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y') }}</li>
                                            <li><i class="feather-users"></i> {{ $activity->students_count ?? $activity->students()->count() }} Peserta</li>
                                        </ul>
                                        <p class="rbt-card-text">{{ Str::limit($activity->description, 80) }}</p>
                                        <div class="rbt-card-bottom">
                                            <div class="rbt-button-group justify-content-start">
                                                {{-- Semua peranan boleh lihat butiran --}}
                                                @role('Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar')
                                                <a class="rbt-btn btn-xs btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   href="{{ route('activities.show', $activity) }}"
                                                   style="width:35px;height:35px;" title="Lihat Butiran & Sijil">
                                                    <i class="feather-award" style="font-size:14px;"></i>
                                                </a>
                                                @endrole
                                                {{-- Pentadbir TIDAK boleh rekod kehadiran --}}
                                                @role('Super Admin|Penyelia KAFA|Guru KAFA|Guru Besar')
                                                <a class="rbt-btn btn-xs btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   href="{{ route('activities.attendance', $activity) }}"
                                                   style="width:35px;height:35px;" title="Penandaan Kehadiran">
                                                    <i class="feather-check-square" style="font-size:14px;"></i>
                                                </a>
                                                {{-- Pentadbir TIDAK boleh edit --}}
                                                <a class="rbt-btn btn-xs btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   href="{{ route('activities.edit', $activity) }}"
                                                   style="width:35px;height:35px;" title="Edit">
                                                    <i class="feather-edit" style="font-size:14px;"></i>
                                                </a>
                                                @endrole
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt--20">
                            {{ $activities->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
