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
                        <div class="section-title mb--20">
                            <h4 class="rbt-title-style-3">Aduan Masalah Pengguna</h4>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Filter --}}
                        <form method="GET" class="d-flex align-items-center flex-wrap gap-2 mb--20">
                            <select name="status" class="form-select form-select-sm" style="width:auto; min-width:150px;">
                                <option value="">Semua Status</option>
                                @foreach($statuses as $key => $s)
                                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $s['label'] }}</option>
                                @endforeach
                            </select>
                            <select name="module" class="form-select form-select-sm" style="width:auto; min-width:200px;">
                                <option value="">Semua Modul</option>
                                @foreach($modules as $m)
                                    <option value="{{ $m }}" {{ request('module') === $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="rbt-btn btn-border btn-sm"><i class="feather-filter me-1"></i>Tapis</button>
                            <a href="{{ route('feedback.index') }}" class="rbt-btn btn-sm" style="background:#f0f0f0; color:#555;"><i class="feather-x me-1"></i>Set Semula</a>
                        </form>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pengguna</th>
                                        <th>Modul</th>
                                        <th>Tarikh</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($feedbacks as $i => $fb)
                                    <tr id="row-{{ $fb->id }}">
                                        <td>{{ $feedbacks->firstItem() + $i }}</td>
                                        <td>
                                            <strong>{{ $fb->user->name ?? '-' }}</strong><br>
                                            <small class="text-muted">{{ $fb->user->getRoleNames()->first() ?? '' }}</small>
                                        </td>
                                        <td><span class="badge bg-secondary-opacity text-secondary px-2">{{ $fb->module }}</span></td>
                                        <td><small>{{ $fb->created_at->format('d/m/Y H:i') }}</small></td>
                                        <td class="text-center">
                                            <span class="badge {{ $fb->status_class }} px-2">{{ $fb->status_label }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('feedback.show', $fb->id) }}" class="rbt-btn-link" title="Lihat">
                                                <i class="feather-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted p-4">Tiada aduan ditemui.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--20">{{ $feedbacks->withQueryString()->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-secondary-opacity { background: rgba(108,117,125,0.1); color: #6c757d; }
</style>
@endsection
