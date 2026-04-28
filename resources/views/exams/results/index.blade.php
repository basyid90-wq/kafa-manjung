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
                            <h4 class="rbt-title-style-3">Kemasukan Markah Peperiksaan</h4>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('exams.results.show') }}" method="GET" class="rbt-profile-row rbt-default-form row row--15">
                            <div class="col-lg-12">
                                <div class="rbt-form-group">
                                    <label for="exam_id">Pilih Peperiksaan</label>
                                    <select id="exam_id" name="exam_id" class="selectpicker" data-width="100%" data-container="body" data-live-search="true" title="-- Pilih Peperiksaan --" required>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->year }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12 mt--20">
                                <div class="rbt-form-group">
                                    <label for="kafa_class_id">Pilih Kelas</label>
                                    <select id="kafa_class_id" name="kafa_class_id" class="selectpicker" data-width="100%" data-container="body" data-live-search="true" title="-- Pilih Kelas --" required>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12 mt--20">
                                <div class="rbt-form-group">
                                    <label for="subject_id">Pilih Mata Pelajaran</label>
                                    <select id="subject_id" name="subject_id" class="selectpicker" data-width="100%" data-container="body" data-live-search="true" data-size="5" title="-- Pilih Mata Pelajaran --" required>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt--30">
                                <div class="rbt-button-group justify-content-start">
                                    <button class="rbt-btn btn-gradient hover-icon-reverse" type="submit">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Teruskan</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
