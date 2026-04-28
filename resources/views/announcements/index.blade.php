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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Papan Hebahan & Pengumuman</h4>
                            <div class="rbt-button-group d-flex gap-2">
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markRead') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="rbt-btn btn-link btn-xs">Tanda Semua Dibaca</button>
                                </form>
                                @endif
                                @role('Super Admin')
                                <a href="{{ route('announcements.create-homepage') }}" class="rbt-btn btn-border btn-sm">
                                    <i class="feather-monitor"></i> Hebahan Homepage
                                </a>
                                @endrole
                                @role('Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Pembekal')
                                <a href="{{ route('announcements.create') }}" class="rbt-btn btn-gradient btn-sm">
                                    <i class="feather-plus"></i> Cipta Hebahan
                                </a>
                                @endrole
                            </div>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success mt--20">{{ session('success') }}</div>
                        @endif

                        <div class="row g-4 mt--20">
                            @forelse($announcements as $announcement)
                            <div class="col-12">
                                <div class="rbt-card variation-01 rbt-hover" style="border: 1px solid #eee; border-radius: 12px; padding: 20px;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <a href="{{ route('announcements.show', $announcement) }}" style="text-decoration: none; color: inherit;">
                                                <h5 class="mb--5">{{ $announcement->title }}</h5>
                                            </a>
                                            <p class="text-muted small mb--10">
                                                <i class="feather-user"></i> {{ $announcement->user->name }} |
                                                <i class="feather-clock"></i> {{ $announcement->created_at->diffForHumans() }}
                                                @if($announcement->is_homepage)
                                                | <span class="badge bg-info-opacity"><i class="feather-monitor"></i> Homepage</span>
                                                @endif
                                                @if($announcement->homepage_label)
                                                | <span class="badge bg-primary-opacity">{{ $announcement->homepage_label }}</span>
                                                @endif
                                                @if($announcement->category)
                                                | <span class="badge bg-secondary-opacity">{{ $announcement->category }}</span>
                                                @endif
                                                @if($announcement->target_role)
                                                | <span class="badge bg-primary-opacity">{{ $announcement->target_role }}</span>
                                                @endif
                                            </p>
                                            <div class="announcement-preview text-muted" style="font-size: 14px;">
                                                {{ Str::limit(strip_tags($announcement->content), 150) }}
                                            </div>
                                            <div class="mt--10">
                                                @if($announcement->is_homepage)
                                                <span class="badge bg-info-opacity"><i class="feather-globe"></i> Paparan Awam</span>
                                                @if($announcement->expires_at)
                                                <span class="badge bg-secondary-opacity"><i class="feather-calendar"></i> Luput: {{ $announcement->expires_at->format('d/m/Y H:i') }}</span>
                                                @endif
                                                @else
                                                    @if($announcement->isReadBy(auth()->user()))
                                                    <span class="badge bg-success-opacity"><i class="feather-check"></i> Dibaca</span>
                                                    @else
                                                    <span class="badge bg-warning-opacity"><i class="feather-bell"></i> Baharu</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @if(!$announcement->is_homepage)
                                            <a href="{{ route('announcements.show', $announcement) }}" class="rbt-btn btn-border btn-xs">
                                                <i class="feather-eye"></i> Lihat
                                            </a>
                                            @endif
                                            @if(Auth::id() === $announcement->user_id || Auth::user()->hasRole('Super Admin'))
                                            <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Padam hebahan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rbt-btn btn-border btn-xs text-danger">
                                                    <i class="feather-trash-2"></i> Padam
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <i class="feather-volume-x" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="mt--15 text-muted">Tiada hebahan buat masa ini.</p>
                            </div>
                            @endforelse
                        </div>

                        {{-- Pagination --}}
                        @if($announcements->hasPages())
                        <div class="row mt--30">
                            <div class="col-12">
                                {{ $announcements->links() }}
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
.bg-secondary-opacity { background: rgba(108, 117, 125, 0.1); color: #6c757d; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
.bg-primary-opacity { background: rgba(110, 65, 255, 0.1); color: #6e41ff; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
.bg-success-opacity { background: rgba(40, 167, 69, 0.1); color: #28a745; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
.bg-warning-opacity { background: rgba(255, 193, 7, 0.1); color: #ffc107; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
.bg-info-opacity { background: rgba(23, 162, 184, 0.1); color: #17a2b8; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
</style>
@endsection
