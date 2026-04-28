<!-- Penyelia KAFA Dashboard Content -->
<div class="row g-5">
    @php
        $penyeliaStatsTop = [
            ['title' => 'Sekolah', 'count' => $data['stats']['schools'], 'icon' => 'feather-home', 'class' => 'bg-primary-opacity', 'color' => 'color-primary'],
            ['title' => 'Guru Besar', 'count' => $data['stats']['guru_besar'], 'icon' => 'feather-user-check', 'class' => 'bg-secondary-opacity', 'color' => 'color-secondary'],
            ['title' => 'Guru KAFA', 'count' => $data['stats']['guru_kafa'], 'icon' => 'feather-users', 'class' => 'bg-pink-opacity', 'color' => 'color-pink'],
        ];
        $penyeliaStatsBottom = [
            ['title' => 'Jumlah Kelas', 'count' => $data['stats']['classes'], 'icon' => 'feather-layers', 'class' => 'bg-warning-opacity', 'color' => 'color-warning'],
            ['title' => 'Jumlah Murid', 'count' => $data['stats']['students'], 'icon' => 'feather-user', 'class' => 'bg-success-opacity', 'color' => 'color-success'],
        ];
    @endphp

    <!-- Top Row: 3 Cards -->
    @foreach($penyeliaStatsTop as $stat)
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed {{ $stat['class'] }}">
            <div class="inner">
                <div class="rbt-round-icon {{ $stat['class'] }}">
                    <i class="{{ $stat['icon'] }}"></i>
                </div>
                <div class="content">
                    <h3 class="counter without-icon {{ $stat['color'] }}"><span class="odometer" data-count="{{ $stat['count'] }}">{{ $stat['count'] }}</span></h3>
                    <span class="rbt-title-style-2 d-block">{{ $stat['title'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Bottom Row: 2 Cards -->
    @foreach($penyeliaStatsBottom as $stat)
    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed {{ $stat['class'] }}">
            <div class="inner">
                <div class="rbt-round-icon {{ $stat['class'] }}">
                    <i class="{{ $stat['icon'] }}"></i>
                </div>
                <div class="content">
                    <h3 class="counter without-icon {{ $stat['color'] }}"><span class="odometer" data-count="{{ $stat['count'] }}">{{ $stat['count'] }}</span></h3>
                    <span class="rbt-title-style-2 d-block">{{ $stat['title'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt--50">
    <div class="col-12">
        <div class="section-title mb--20">
            <h5 class="rbt-title-style-2">RPH Menunggu Kelulusan (Daerah)</h5>
        </div>
        <div class="rbt-dashboard-table table-responsive">
            <table class="rbt-table table table-borderless">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Guru / Sekolah</th>
                        <th>Tarikh / Minggu</th>
                        <th>Topik</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['pending_rphs'] as $rph)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <p class="mb--0"><strong>{{ $rph->user->name }}</strong></p>
                            <span class="small text-muted">{{ $rph->school->name }}</span>
                        </td>
                        <td>
                            <p class="mb--0">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</p>
                            <span class="small text-muted">Minggu {{ $rph->week }}</span>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($rph->topic, 40) }}</td>
                        <td><span class="rbt-badge-5 bg-warning-opacity color-warning">Pending</span></td>
                        <td>
                            <a href="{{ route('rph_approvals.index') }}" class="rbt-btn-link text-primary"><i class="feather-check-square"></i> Urus</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Tiada RPH menunggu kelulusan ketika ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media (max-width: 991px) {
        .col-lg-20 {
            flex: 0 0 33.333% !important;
            max-width: 33.333% !important;
        }
    }
    @media (max-width: 575px) {
        .col-lg-20 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
    }
</style>
