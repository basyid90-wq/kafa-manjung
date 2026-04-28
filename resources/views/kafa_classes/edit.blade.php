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
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box" style="overflow: visible !important;">
                    <div class="content" style="padding-top: 50px !important;">
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Kemaskini Kelas</h4>
                        </div>

                        <form action="{{ route('kafa_classes.update', $kafaClass) }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf @method('PUT')
                            
                            @hasanyrole('Super Admin|Pentadbir')
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="school_id">Pilih Sekolah</label>
                                    <select name="school_id" id="school_id" class="rbt-big-select" required>
                                        <option value="">-- Pilih Sekolah --</option>
                                        @foreach($schools as $school)
                                        <option value="{{ $school->id }}" {{ old('school_id', $kafaClass->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="school_id" value="{{ auth()->user()->school_id }}">
                            @endhasanyrole

                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="rbt-form-group">
                                    <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                    <select id="tahun" name="tahun" class="rbt-big-select" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @for($t = 1; $t <= 6; $t++)
                                            <option value="{{ $t }}" {{ old('tahun', $kafaClass->tahun) == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-8 col-12">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Kelas <span class="text-danger">*</span></label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $kafaClass->name) }}" required>
                                    <small class="color-body">Nama kelas tanpa nombor tahun, sama seperti dalam SIMPENI.</small>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="teacher_id">Guru Kelas (Pilihan)</label>
                                    <select name="teacher_id" id="teacher_id" class="rbt-big-select">
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ (isset($kafaClass) && $kafaClass->teacher_id == $teacher->id) ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <button class="rbt-btn btn-gradient" type="submit">Kemaskini Rekod</button>
                                    <a class="rbt-btn btn-border" href="{{ route('kafa_classes.index') }}">Batal</a>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Matikan selectpicker jika ia wujud pada elemen ini
    function destroySelectPicker(id) {
        const el = $(id);
        if (el.length && typeof el.selectpicker === 'function') {
            el.selectpicker('destroy');
            // Paksa gaya paparan jika ia disembunyikan oleh plugin
            el.show().css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1',
                'position': 'relative'
            });
        }
    }

    destroySelectPicker('#school_id');
    destroySelectPicker('#teacher_id');
    destroySelectPicker('#tahun');

    const schoolSelect = document.getElementById('school_id');
    const teacherSelect = document.getElementById('teacher_id');

    if (schoolSelect) {
        schoolSelect.addEventListener('change', function () {
            const schoolId = this.value;
            teacherSelect.innerHTML = '<option value="">-- Memuatkan... --</option>';

            if (!schoolId) {
                teacherSelect.innerHTML = '<option value="">-- Pilih Sekolah Terlebih Dahulu --</option>';
                return;
            }

            // Gunakan {{ url('get-teachers') }} untuk memastikan path yang betul mengikut persekitaran (Lokal/Pelayan)
            const fetchUrl = "{{ url('get-teachers') }}/" + schoolId;

            fetch(fetchUrl)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    teacherSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = "";
                        option.text = "Tiada Guru Berdaftar di Sekolah Ini";
                        teacherSelect.add(option);
                    } else {
                        data.forEach(teacher => {
                            const option = document.createElement('option');
                            option.value = teacher.id;
                            option.text = teacher.name;
                            teacherSelect.add(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching teachers:', error);
                    teacherSelect.innerHTML = '<option value="">-- Ralat memuatkan data --</option>';
                });
        });
    }
});
</script>
@endpush
