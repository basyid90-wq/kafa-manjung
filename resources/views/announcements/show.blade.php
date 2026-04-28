@extends('layout.layout')

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container text-start">
        <div class="row mt--0">
            @include('partials.sidebar')
            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Butiran Hebahan</h4>
                            <a href="{{ route('announcements.index') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <div class="rbt-card variation-01 rbt-hover" style="border: 1px solid #eee; border-radius: 12px; padding: 30px;">

                            {{-- Header --}}
                            <div class="d-flex justify-content-between align-items-start mb--20">
                                <div class="flex-grow-1">
                                    <h3 class="mb--10">{{ $announcement->title }}</h3>
                                    <div class="d-flex flex-wrap gap-3 align-items-center text-muted small">
                                        <span>
                                            <i class="feather-user"></i> {{ $announcement->user->name }}
                                        </span>
                                        <span>
                                            <i class="feather-clock"></i> {{ $announcement->created_at->format('d/m/Y, h:i A') }}
                                        </span>
                                        @if($announcement->category)
                                        <span class="badge bg-secondary-opacity">{{ $announcement->category }}</span>
                                        @endif
                                        @if($announcement->target_role)
                                        <span class="badge bg-primary-opacity">Sasaran: {{ $announcement->target_role }}</span>
                                        @endif
                                    </div>
                                </div>
                                @if(Auth::id() === $announcement->user_id || Auth::user()->hasRole('Super Admin'))
                                <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Padam hebahan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0">
                                        <i class="feather-trash-2"></i>
                                    </button>
                                </form>
                                @endif
                            </div>

                            <hr class="mb--20">

                            {{-- Content --}}
                            <div class="announcement-content" style="line-height: 1.8; font-size: 15px;">
                                {!! nl2br(e($announcement->content)) !!}
                            </div>

                            <hr class="mt--30 mb--20">

                            {{-- Footer Info --}}
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <div>
                                    @if($announcement->school_id)
                                        <span class="badge bg-success">Sekolah: {{ $announcement->school->name }}</span>
                                    @elseif($announcement->district_id)
                                        <span class="badge bg-info">Daerah: {{ $announcement->district->name }}</span>
                                    @endif
                                </div>
                                <div>
                                    <i class="feather-eye"></i>
                                    {{ $announcement->read_count }} / {{ $announcement->target_count }} telah membaca
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-secondary-opacity { background: rgba(108, 117, 125, 0.1); color: #6c757d; }
.bg-primary-opacity { background: rgba(110, 65, 255, 0.1); color: #6e41ff; }
</style>
@endsection
