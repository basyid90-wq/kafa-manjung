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
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Butiran Aduan</h4>
                            <a href="{{ route('feedback.index') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Info aduan --}}
                        <div class="rbt-shadow-box p--20 mb--20" style="background:#f8f9fa; border-radius:8px;">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Pengguna</small>
                                    <strong>{{ $feedback->user->name ?? '-' }}</strong>
                                    <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $feedback->user->getRoleNames()->first() ?? '' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Modul</small>
                                    <strong>{{ $feedback->module }}</strong>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Tarikh Hantar</small>
                                    <strong>{{ $feedback->created_at->format('d/m/Y H:i') }}</strong>
                                </div>
                            </div>
                        </div>

                        {{-- Penerangan --}}
                        <div class="mb--20">
                            <h6 class="rbt-title-style-2 mb--10">Penerangan Masalah</h6>
                            <div class="rbt-shadow-box p--20" style="background:white; border:1px solid #e6e6e6; border-radius:8px; white-space:pre-line; line-height:1.8;">{{ $feedback->description }}</div>
                        </div>

                        {{-- Tangkapan skrin --}}
                        @if($feedback->image_path)
                        <div class="mb--20">
                            <h6 class="rbt-title-style-2 mb--10">Tangkapan Skrin</h6>
                            <img src="{{ Storage::url($feedback->image_path) }}" alt="Screenshot"
                                 style="max-width:100%; border-radius:8px; border:1px solid #ddd; cursor:pointer;"
                                 onclick="this.style.maxWidth = this.style.maxWidth === '100%' ? '600px' : '100%'">
                            <p><small class="text-muted">Klik imej untuk zoom</small></p>
                        </div>
                        @endif

                        {{-- Form kemaskini status --}}
                        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row g-3 mt--10">
                                <div class="col-md-4">
                                    <div class="rbt-form-group">
                                        <label>Status</label>
                                        <select name="status" class="rbt-big-select">
                                            @foreach(\App\Models\Feedback::STATUSES as $key => $s)
                                                <option value="{{ $key }}" {{ $feedback->status === $key ? 'selected' : '' }}>
                                                    {{ $s['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="rbt-form-group">
                                        <label>Balasan / Nota (Dalaman)</label>
                                        <textarea name="admin_reply" rows="4" class="form-control"
                                                  placeholder="Tulis nota tindakan atau balasan untuk rekod...">{{ $feedback->admin_reply }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mt--20">
                                <button type="submit" class="rbt-btn btn-gradient btn-sm">
                                    <i class="feather-save me-1"></i> Simpan Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
