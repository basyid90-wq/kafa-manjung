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
                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">Log Sistem</h4>
                            <a href="{{ route('dashboard') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                        {{-- Filter paras log --}}
                        <form method="GET" class="d-flex align-items-center gap-2 mb--20">
                            <select name="level" class="form-select form-select-sm" style="width:auto; min-width:160px;">
                                <option value="error"   {{ $filterLevel === 'error'   ? 'selected' : '' }}>Error sahaja</option>
                                <option value="warning" {{ $filterLevel === 'warning' ? 'selected' : '' }}>Warning sahaja</option>
                                <option value="info"    {{ $filterLevel === 'info'    ? 'selected' : '' }}>Info sahaja</option>
                                <option value="all"     {{ $filterLevel === 'all'     ? 'selected' : '' }}>Semua paras</option>
                            </select>
                            <button type="submit" class="rbt-btn btn-border btn-sm"><i class="feather-filter me-1"></i>Tapis</button>
                        </form>

                        @if(empty($entries))
                            <div class="alert alert-success">
                                <i class="feather-check-circle me-1"></i> Tiada entri log untuk paras yang dipilih. Sistem berjalan lancar.
                            </div>
                        @else
                        <p class="text-muted mb--15" style="font-size:12px;">Menunjukkan {{ count($entries) }} entri terkini (50 maksimum)</p>

                        @foreach($entries as $entry)
                        @php
                            $levelClass = match($entry['level']) {
                                'error', 'critical', 'emergency', 'alert' => 'danger',
                                'warning' => 'warning',
                                'notice', 'info' => 'info',
                                default => 'secondary',
                            };
                        @endphp
                        <div class="rbt-shadow-box mb--15 p--15" style="border-left: 4px solid var(--bs-{{ $levelClass }}); border-radius:4px; background:#fafafa;">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="badge bg-{{ $levelClass }}">{{ strtoupper($entry['level']) }}</span>
                                <small class="text-muted">{{ $entry['datetime'] }}</small>
                            </div>
                            <p class="mb-1" style="font-size:13px; font-family: monospace; word-break:break-all;">{{ $entry['message'] }}</p>
                            @if(!empty(trim($entry['trace'])))
                            <details>
                                <summary style="font-size:11px; color:#999; cursor:pointer;">Lihat Stack Trace</summary>
                                <pre style="font-size:10px; max-height:150px; overflow-y:auto; background:#f0f0f0; padding:8px; border-radius:4px; margin-top:5px;">{{ trim($entry['trace']) }}</pre>
                            </details>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
