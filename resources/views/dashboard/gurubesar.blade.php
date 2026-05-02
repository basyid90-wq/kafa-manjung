<!-- Guru Besar Dashboard Content -->
<div class="row g-5">
    @php
        $gurubesarStats = [
            ['title' => 'Guru KAFA', 'count' => $data['stats']['guru_kafa'], 'icon' => 'feather-users', 'class' => 'bg-primary-opacity', 'color' => 'color-primary'],
            ['title' => 'Jumlah Kelas', 'count' => $data['stats']['classes'], 'icon' => 'feather-layers', 'class' => 'bg-secondary-opacity', 'color' => 'color-secondary'],
            ['title' => 'Jumlah Murid', 'count' => $data['stats']['students'], 'icon' => 'feather-book-open', 'class' => 'bg-pink-opacity', 'color' => 'color-pink'],
        ];
    @endphp

    @foreach($gurubesarStats as $stat)
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed {{ $stat['class'] }}">
            <div class="inner">
                <div class="rbt-round-icon {{ $stat['class'] }}">
                    <i class="{{ $stat['icon'] }}"></i>
                </div>
                <div class="content">
                    <h3 class="counter without-icon {{ $stat['color'] }}" style="font-size:2rem;font-weight:700;">{{ $stat['count'] }}</h3>
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
            <h5 class="rbt-title-style-2">Permohonan RPH Terkini</h5>
        </div>
        <div class="rbt-dashboard-table table-responsive">
            <table class="rbt-table table table-borderless">
                <thead>
                    <tr>
                        <th>Nama Guru</th>
                        <th>Tarikh / Minggu</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['pending_rphs'] as $rph)
                    <tr>
                        <td>{{ $rph->user->name }}</td>
                        <td>
                            <p class="mb--0">{{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}</p>
                            <span class="small text-muted">Minggu {{ $rph->week }}</span>
                        </td>
                        <td><span class="rbt-badge-5 bg-warning-opacity color-warning">Pending</span></td>
                        <td>
                            <a href="{{ route('rph_approvals.index') }}" class="rbt-btn-link text-primary"><i class="feather-check-square"></i> Semak</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Tiada RPH menunggu semakan ketika ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
