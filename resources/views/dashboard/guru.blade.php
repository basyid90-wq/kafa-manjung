<!-- Guru KAFA Dashboard Content -->
<div class="row g-5">
    @php
        $guruStats = [
            ['title' => 'Kelas Diajar', 'count' => $data['stats']['classes_taught'], 'icon' => 'feather-layers', 'class' => 'bg-primary-opacity', 'color' => 'color-primary'],
            ['title' => 'Jumlah Murid', 'count' => $data['stats']['students_supervised'], 'icon' => 'feather-users', 'class' => 'bg-secondary-opacity', 'color' => 'color-secondary'],
            ['title' => 'Hebahan Baharu', 'count' => $data['stats']['announcements_count'], 'icon' => 'feather-bell', 'class' => 'bg-pink-opacity', 'color' => 'color-pink'],
        ];
    @endphp

    @foreach($guruStats as $stat)
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
            <h5 class="rbt-title-style-2">Jadual Pengajaran Hari Ini ({{ \Carbon\Carbon::now()->translatedFormat('l') }})</h5>
        </div>
        <div class="rbt-dashboard-table table-responsive">
            <table class="rbt-table table table-borderless">
                <thead>
                    <tr>
                        <th>Masa</th>
                        <th>Kelas</th>
                        <th>Subjek</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['today_schedule'] as $timetable)
                    <tr>
                        <td>
                            <p class="mb--0"><strong>{{ \Carbon\Carbon::parse($timetable->timeSlot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($timetable->timeSlot->end_time)->format('h:i A') }}</strong></p>
                        </td>
                        <td>{{ $timetable->kafaClass->display_name }}</td>
                        <td>{{ $timetable->subject->name }}</td>
                        <td>
                            <a href="{{ route('rph.create', ['class_id' => $timetable->kafa_class_id]) }}" class="rbt-btn-link text-primary"><i class="feather-plus-circle"></i> Bina RPH</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Tiada jadual pengajaran untuk hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
