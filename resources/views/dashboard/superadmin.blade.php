{{-- Super Admin Dashboard --}}
@php
    $cards = [
        [
            'title'  => 'Sekolah Aktif',
            'count'  => $data['stats']['schools'],
            'icon'   => 'feather-home',
            'class'  => 'bg-primary-opacity',
            'color'  => 'color-primary',
        ],
        [
            'title'  => 'Pengguna Aktif',
            'count'  => $data['stats']['active_users'],
            'icon'   => 'feather-users',
            'class'  => 'bg-secondary-opacity',
            'color'  => 'color-secondary',
            'note'   => '90 hari terakhir',
        ],
        [
            'title'  => 'Jumlah Murid',
            'count'  => $data['stats']['students'],
            'icon'   => 'feather-user',
            'class'  => 'bg-pink-opacity',
            'color'  => 'color-pink',
        ],
        [
            'title'  => 'Pengguna Baharu',
            'count'  => $data['stats']['new_users_30'],
            'icon'   => 'feather-user-plus',
            'class'  => 'bg-warning-opacity',
            'color'  => 'color-warning',
            'note'   => '30 hari terakhir',
        ],
    ];
@endphp

{{-- Baris 1: Stat Cards --}}
<div class="row g-4 mb--30">
    @foreach($cards as $card)
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed {{ $card['class'] }}">
            <div class="inner">
                <div class="rbt-round-icon {{ $card['class'] }}">
                    <i class="{{ $card['icon'] }}"></i>
                </div>
                <div class="content">
                    <h3 class="counter without-icon {{ $card['color'] }}">
                        <span class="odometer" data-count="{{ $card['count'] }}">{{ $card['count'] }}</span>
                    </h3>
                    <span class="rbt-title-style-2 d-block">{{ $card['title'] }}</span>
                    @isset($card['note'])
                    <small class="text-muted" style="font-size:10px;">{{ $card['note'] }}</small>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Baris 2: Aduan Terkini + System Health --}}
<div class="row g-4">

    {{-- Panel Kiri: Aduan Masalah Terkini --}}
    <div class="col-lg-7">
        <div class="rbt-shadow-box p--20" style="background:#fff; border-radius:8px; height:100%;">
            <div class="d-flex justify-content-between align-items-center mb--15">
                <h6 class="rbt-title-style-2 mb-0">Aduan Masalah Terkini</h6>
                <a href="{{ route('feedback.index') }}" class="rbt-btn-link" style="font-size:12px;">
                    Lihat Semua <i class="feather-arrow-right ms-1"></i>
                </a>
            </div>

            {{-- Badge counts --}}
            <div class="d-flex gap-2 mb--15">
                <span class="badge bg-danger px-2">
                    {{ $data['feedback_counts']['baru'] }} Baru
                </span>
                <span class="badge bg-warning text-dark px-2">
                    {{ $data['feedback_counts']['dalam_semakan'] }} Dalam Semakan
                </span>
                <span class="badge bg-success px-2">
                    {{ $data['feedback_counts']['selesai'] }} Selesai
                </span>
            </div>

            @if($data['recent_feedback']->isEmpty())
                <p class="text-muted" style="font-size:13px;"><i class="feather-check-circle me-1 text-success"></i>Tiada aduan buat masa ini.</p>
            @else
                <ul class="list-unstyled mb-0">
                    @foreach($data['recent_feedback'] as $fb)
                    <li class="d-flex justify-content-between align-items-start py-2"
                        style="border-bottom:1px solid #f0f0f0; {{ $loop->last ? 'border-bottom:none;' : '' }}">
                        <div style="flex:1; min-width:0;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge {{ $fb->status_class }} px-2" style="font-size:10px;">{{ $fb->status_label }}</span>
                                <span class="badge bg-secondary-opacity px-2" style="font-size:10px;">{{ $fb->module }}</span>
                            </div>
                            <p class="mb-0 text-truncate" style="font-size:12px; color:#555;">
                                {{ Str::limit($fb->description, 80) }}
                            </p>
                            <small class="text-muted" style="font-size:11px;">
                                {{ $fb->user->name ?? '-' }} &bull; {{ $fb->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <a href="{{ route('feedback.show', $fb->id) }}" class="rbt-btn-link ms-2" style="font-size:12px; white-space:nowrap;">
                            <i class="feather-eye"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Panel Kanan: Kesihatan Sistem --}}
    <div class="col-lg-5">
        <div class="rbt-shadow-box p--20" style="background:#fff; border-radius:8px; height:100%;">
            <div class="d-flex justify-content-between align-items-center mb--15">
                <h6 class="rbt-title-style-2 mb-0">Kesihatan Sistem</h6>
                <a href="{{ route('admin.system_log') }}" class="rbt-btn-link" style="font-size:12px;">
                    Log Penuh <i class="feather-arrow-right ms-1"></i>
                </a>
            </div>

            <ul class="list-unstyled mb-0">
                {{-- DB Status --}}
                <li class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;"><i class="feather-database me-2 text-muted"></i>Pangkalan Data</span>
                    @if($data['db_ok'])
                        <span class="badge bg-success px-2">Online</span>
                    @else
                        <span class="badge bg-danger px-2">Ralat</span>
                    @endif
                </li>

                {{-- Storage Status --}}
                <li class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;"><i class="feather-hard-drive me-2 text-muted"></i>Storan Fail</span>
                    @if($data['storage_ok'])
                        <span class="badge bg-success px-2">Boleh Tulis</span>
                    @else
                        <span class="badge bg-danger px-2">Tidak Boleh Tulis</span>
                    @endif
                </li>

                {{-- Last Error --}}
                <li class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;"><i class="feather-alert-triangle me-2 text-muted"></i>Ralat Terakhir</span>
                    @if($data['last_error_time'])
                        <span class="text-danger" style="font-size:11px; font-family:monospace;">{{ $data['last_error_time'] }}</span>
                    @else
                        <span class="badge bg-success px-2">Tiada Ralat</span>
                    @endif
                </li>

                {{-- PHP Version --}}
                <li class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;"><i class="feather-code me-2 text-muted"></i>PHP</span>
                    <span class="badge bg-secondary-opacity px-2" style="font-size:10px;">{{ PHP_VERSION }}</span>
                </li>

                {{-- Laravel Version --}}
                <li class="d-flex justify-content-between align-items-center py-2">
                    <span style="font-size:13px;"><i class="feather-layers me-2 text-muted"></i>Laravel</span>
                    <span class="badge bg-secondary-opacity px-2" style="font-size:10px;">{{ app()->version() }}</span>
                </li>
            </ul>
        </div>
    </div>

</div>
