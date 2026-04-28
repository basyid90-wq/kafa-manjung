@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
@endphp

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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Jadual Waktu Kelas</h4>
                            <div class="rbt-button-group justify-content-end">
                                @if($classId)
                                <a href="javascript:void(0);" onclick="openPdfBlob(this, '{{ route('timetable.pdf', $classId) }}')" class="rbt-btn btn-sm btn-border-gradient">
                                    <i class="feather-printer"></i> Cetak Jadual Kelas
                                </a>
                                @endif
                                @role('Guru Besar')
                                <a href="{{ route('time_slots.index') }}" class="rbt-btn btn-sm btn-border-gradient">Set Waktu Mengajar</a>
                                @endrole
                                @role('Super Admin|Pentadbir|Guru Besar|Guru KAFA')
                                <a href="{{ route('timetable.create') }}" class="rbt-btn btn-sm btn-gradient">Kemaskini Jadual</a>
                                @endrole
                            </div>
                        </div>

                        <form action="{{ route('timetable.index') }}" method="GET" class="mb--30 row">
                            @role('Penyelia KAFA')
                            <div class="col-md-6">
                                <div class="rbt-form-group">
                                    <label>Pilih Sekolah</label>
                                    <select name="school_id" class="rbt-big-select" onchange="this.form.submit()">
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}" {{ $schoolId == $school->id ? 'selected' : '' }}>
                                                {{ $school->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole

                            <div class="col-md-6">
                                <div class="rbt-form-group">
                                    <label>Pilih Kelas</label>
                                    <select name="kafa_class_id" class="rbt-big-select" onchange="this.form.submit()">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                                {{ $class->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="bg-color-primary-opacity">
                                    <tr>
                                        <th style="width: 15%">Slot / Masa</th>
                                        @foreach($days as $day)
                                            <th>{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($slots as $slot)
                                    <tr>
                                        <td class="bg-color-primary-opacity">
                                            <strong>{{ $slot->name }}</strong><br>
                                            <small>{{ date('h:i A', strtotime($slot->start_time)) }} - {{ date('h:i A', strtotime($slot->end_time)) }}</small>
                                        </td>
                                        @foreach($days as $day)
                                            <td style="min-width: 120px; vertical-align: middle;">
                                                @if(isset($timetableData[$slot->id][$day]))
                                                    <div class="rbt-badge bg-primary-opacity mb--5" style="display: block; white-space: normal;">
                                                        {{ $timetableData[$slot->id][$day]->subject->name }}
                                                    </div>
                                                    <small class="text-muted d-block" style="line-height: 1.2;">
                                                        {{ $timetableData[$slot->id][$day]->teacher->name }}
                                                    </small>
                                                @else
                                                    <span class="text-disabled">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">Tiada slot masa ditetapkan. Sila hubungi Guru Besar untuk menetapkan slot masa.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Scroll retention
    window.onload = function() {
        if (localStorage.getItem('timetable_scroll')) {
            window.scrollTo(0, localStorage.getItem('timetable_scroll'));
        }
    };
    window.onscroll = function() {
        localStorage.setItem('timetable_scroll', window.scrollY);
    };
</script>
@endsection
