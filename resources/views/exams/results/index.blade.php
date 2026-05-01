@extends('layout.layout')

@php $bodyClass = ''; $footer = 'true'; @endphp

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
                            <h4 class="rbt-title-style-3">Kemasukan Markah Peperiksaan</h4>
                            <a href="{{ route('exams.index') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-settings me-1"></i> Urus Peperiksaan
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- FIX 1: Peringatan slot subjek hilang --}}
                        @if(!empty($missingSlots))
                        <div class="alert alert-danger d-flex align-items-start gap-2 mb--20">
                            <i class="feather-alert-triangle mt-1 flex-shrink-0"></i>
                            <div>
                                <strong>Amaran: {{ count($missingSlots) }} subjek KAFA tiada rekod dalam sistem!</strong><br>
                                <small>Slot berikut belum ada subjek dengan <code>form_slot</code> ditetapkan — markah untuk slot ini <strong>tidak akan muncul</strong> dalam Rekod Pencapaian Murid:</small>
                                <div class="mt-1">
                                    @foreach($missingSlots as $slot)
                                        <span class="badge bg-danger me-1">{{ $slot }}</span>
                                    @endforeach
                                </div>
                                <small class="text-muted mt-1 d-block">Sila tetapkan <strong>Form Slot</strong> yang betul pada setiap subjek dalam Pengurusan Subjek.</small>
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('exams.results.show') }}" method="GET" class="rbt-profile-row rbt-default-form row row--15">
                            <div class="col-lg-12">
                                <div class="rbt-form-group">
                                    <label for="exam_id">Pilih Peperiksaan</label>
                                    <select id="exam_id" name="exam_id" class="selectpicker" data-width="100%" data-container="body" data-live-search="true" title="-- Pilih Peperiksaan --" required>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->year }}) — {{ ucfirst(str_replace('_', ' ', $exam->term)) }}</option>
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
                                    <label for="subject_id">
                                        Pilih Mata Pelajaran
                                        <small class="text-muted ms-1">(🔗 = tersambung ke Rekod Pencapaian)</small>
                                    </label>
                                    <select id="subject_id" name="subject_id" class="selectpicker" data-width="100%" data-container="body" data-live-search="true" data-size="8" title="-- Pilih Mata Pelajaran --" required>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                data-content="{{ $subject->slot_linked ? '🔗' : ($subject->has_slot ? '⚠️' : '❌') }} {{ e($subject->name) }}{{ $subject->form_slot ? ' <small class=\'text-muted\'>['.$subject->form_slot.']</small>' : ' <small class=\'text-danger\'>[tiada slot]</small>' }}">
                                                {{ $subject->slot_linked ? '🔗' : ($subject->has_slot ? '⚠️' : '❌') }} {{ $subject->name }}{{ $subject->form_slot ? ' ['.$subject->form_slot.']' : ' [tiada slot]' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted d-block mt-1">
                                        🔗 Tersambung ke Rekod Pencapaian &nbsp;|&nbsp;
                                        ⚠️ Ada slot tapi tidak dikenali &nbsp;|&nbsp;
                                        ❌ Tiada form_slot — markah tidak akan muncul dalam Rekod Pencapaian
                                    </small>
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
