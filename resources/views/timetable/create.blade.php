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
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Kemaskini Jadual Waktu</h4>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('timetable.store') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="kafa_class_id">Kelas</label>
                                    <select id="kafa_class_id" name="kafa_class_id" class="rbt-big-select" style="height: 50px;" required>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="day_of_week">Hari</label>
                                    <select id="day_of_week" name="day_of_week" class="rbt-big-select" style="height: 50px;" required>
                                        @foreach($days as $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="time_slot_id">Slot Masa</label>
                                    <select id="time_slot_id" name="time_slot_id" class="rbt-big-select" style="height: 50px;" required>
                                        @forelse($slots as $slot)
                                            <option value="{{ $slot->id }}">
                                                {{ $slot->name }} ({{ date('h:i A', strtotime($slot->start_time)) }} - {{ date('h:i A', strtotime($slot->end_time)) }})
                                            </option>
                                        @empty
                                            <option value="">-- Tiada Slot Masa --</option>
                                        @endforelse
                                    </select>
                                    @if($slots->isEmpty())
                                        <small class="text-danger">Sila <a href="{{ route('time_slots.index') }}">tetapkan slot masa</a> terlebih dahulu.</small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="subject_id">Mata Pelajaran</label>
                                    <select id="subject_id" name="subject_id" class="rbt-big-select" style="height: 50px;" required>
                                        @forelse($subjects as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                        @empty
                                            <option value="">-- Tiada Mata Pelajaran --</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="rbt-form-group">
                                    <label for="user_id">Guru Pengajar</label>
                                    <select id="user_id" name="user_id" class="rbt-big-select" style="height: 50px;" required>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ auth()->id() == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt--30">
                                <div class="rbt-button-group justify-content-start">
                                    <button class="rbt-btn btn-gradient hover-icon-reverse" type="submit" style="height: 50px;">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Simpan Jadual</span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                            <span class="btn-icon"><i class="feather-check"></i></span>
                                        </span>
                                    </button>
                                    <a href="{{ route('timetable.index') }}" class="rbt-btn btn-border-gradient" style="height: 50px; line-height: 48px;">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Scroll retention
    window.onscroll = function() {
        localStorage.setItem('create_timetable_scroll', window.scrollY);
    };
    window.onload = function() {
        if (localStorage.getItem('create_timetable_scroll')) {
            window.scrollTo(0, localStorage.getItem('create_timetable_scroll'));
        }
    };
</script>
@endsection
