<!-- Admin Dashboard Content -->
<div class="row g-5">
    @php
        $adminStats = [
            ['title' => 'Pentadbir', 'count' => $data['user_counts']['Admin'], 'icon' => 'feather-shield', 'class' => 'bg-primary-opacity', 'color' => 'color-primary'],
            ['title' => 'Penyelia KAFA', 'count' => $data['user_counts']['Penyelia'], 'icon' => 'feather-map', 'class' => 'bg-secondary-opacity', 'color' => 'color-secondary'],
            ['title' => 'Guru Besar', 'count' => $data['user_counts']['Guru Besar'], 'icon' => 'feather-user-check', 'class' => 'bg-pink-opacity', 'color' => 'color-pink'],
            ['title' => 'Pembekal', 'count' => $data['user_counts']['Pembekal'], 'icon' => 'feather-truck', 'class' => 'bg-warning-opacity', 'color' => 'color-warning'],
        ];
    @endphp

    @foreach($adminStats as $stat)
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
            <h5 class="rbt-title-style-2">Ringkasan Data Daerah</h5>
        </div>
        <div class="rbt-dashboard-table table-responsive">
            <table class="rbt-table table table-borderless">
                <thead>
                    <tr>
                        <th>Daerah</th>
                        <th>Jumlah Sekolah</th>
                        <th>Jumlah Murid</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['districts'] as $district)
                    <tr>
                        <th>{{ $district->name }}</th>
                        <td>{{ $district->schools_count }} Sekolah</td>
                        <td>{{ $district->students_count }} Murid</td>
                        <td>
                            <a href="{{ route('districts.show', $district->id) }}" class="rbt-btn-link text-primary"><i class="feather-eye"></i> Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
