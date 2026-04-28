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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Permohonan Pindah Murid</h4>
                            <a href="{{ route('student_transfers.index') }}" class="rbt-btn btn-sm btn-border">
                                <i class="feather-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <form action="{{ route('student_transfers.store') }}" method="POST" class="mt--30">
                            @csrf

                            <div class="row g-5">
                                @if($student)
                                    {{-- Mode 1: From Profile (Read-Only) --}}
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <div class="col-12">
                                        <div class="rbt-form-group">
                                            <label class="form-label">Nama Murid</label>
                                            <div class="form-control d-flex align-items-center" style="height: 50px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 6px; padding: 0 15px; font-size: 1.25rem; font-weight: 600; color: #333;">
                                                {{ $student->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rbt-form-group">
                                            <label class="form-label">Kelas Semasa</label>
                                            <div class="form-control d-flex align-items-center" style="height: 50px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 6px; padding: 0 15px; font-size: 1.25rem; font-weight: 600; color: #333;">
                                                {{ $student->kafaClass->display_name ?? 'Tiada Kelas' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rbt-form-group">
                                            <label class="form-label">Sekolah Asal</label>
                                            <div class="form-control d-flex align-items-center" style="height: 50px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 6px; padding: 0 15px; font-size: 1.25rem; font-weight: 600; color: #333;">
                                                {{ $student->school->name }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Mode 2: New Application (AJAX Selection) --}}
                                    <div class="col-md-6">
                                        <div class="rbt-form-group">
                                            <label class="form-label">Pilih Kelas <span class="text-danger">*</span></label>
                                            <select id="class_select" class="form-select selectpicker" data-live-search="true" style="height: 50px; border: 1px solid #ddd; border-radius: 6px; padding: 0 15px;" required>
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rbt-form-group">
                                            <label class="form-label">Pilih Murid <span class="text-danger">*</span></label>
                                            <select name="student_id" id="student_select" class="form-select selectpicker" data-live-search="true" style="height: 50px; border: 1px solid #ddd; border-radius: 6px; padding: 0 15px;" disabled required>
                                                <option value="">-- Pilih Murid --</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="rbt-form-group">
                                        <label class="form-label">Sekolah Destinasi <span class="text-danger">*</span></label>
                                        <select name="to_school_id" class="form-select selectpicker" data-live-search="true" style="height: 50px; border: 1px solid #ddd; border-radius: 6px; padding: 0 15px;" required>
                                            <option value="">-- Pilih Sekolah --</option>
                                            @foreach($groupedSchools as $districtName => $schools)
                                                <optgroup label="Daerah: {{ $districtName }}">
                                                    @foreach($schools as $school)
                                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="rbt-form-group">
                                        <label class="form-label">Sebab Berpindah</label>
                                        <textarea name="reason" rows="3" placeholder="Sila nyatakan sebab murid berpindah..." style="border: 1px solid #ddd; border-radius: 6px; padding: 15px; width: 100%;"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mt--30">
                                    <button type="submit" class="rbt-btn btn-gradient w-100" style="height: 50px;">Hantar Permohonan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$student)
@push('scripts')
<script>
console.log('Modul Pindah Murid: Skrip dimuatkan.');

function loadStudents(classId) {
    console.log('Memulakan pengambilan murid untuk Class ID:', classId);
    var $studentSelect = $('#student_select');

    // Reset & Tunjukkan status memuatkan
    $studentSelect.html('<option value="">-- Memuatkan murid... --</option>');
    $studentSelect.prop('disabled', true);
    $studentSelect.selectpicker('refresh');

    var url = "{{ route('student_transfers.get_students', ':id') }}".replace(':id', classId);

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Pelayan mengembalikan ralat HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Data murid diterima:', data);
            var options = '<option value="">-- Pilih Murid --</option>';
            
            if (data && data.length > 0) {
                data.forEach(function(student) {
                    options += '<option value="' + student.id + '">' + student.name + '</option>';
                });
                $studentSelect.html(options);
                $studentSelect.prop('disabled', false);
            } else {
                $studentSelect.html('<option value="">Tiada murid ditemui</option>');
                $studentSelect.prop('disabled', true);
            }
            
            // Refresh bootstrap-select
            $studentSelect.selectpicker('refresh');
            console.log('Dropdown murid telah dikemaskini.');
        })
        .catch(error => {
            console.error('Ralat AJAX:', error);
            alert('Gagal memuatkan senarai murid: ' + error.message);
            
            $studentSelect.html('<option value="">Ralat memuatkan data</option>');
            $studentSelect.selectpicker('refresh');
        });
}

// Pantau acara 'change' dan 'changed.bs.select'
$(document).on('change changed.bs.select', '#class_select', function() {
    var classId = $(this).val();
    if (classId) {
        loadStudents(classId);
    }
});

// Inisialisasi awal jika ada nilai terpilih (back-button fix)
var initialClass = $('#class_select').val();
if (initialClass) {
    loadStudents(initialClass);
}
</script>
@endpush
@endif

@endsection
