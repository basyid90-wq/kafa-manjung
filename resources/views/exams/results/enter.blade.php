@extends('layout.layout')

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--100">
                    <div class="content">
                        <div class="section-title mb--30">
                            <h4 class="rbt-title-style-3">Kemasukan Markah Peperiksaan</h4>
                            <div class="d-flex flex-wrap gap-2 mt--10">
                                <span class="badge bg-primary-opacity text-primary px-3">{{ $exam->name }}</span>
                                <span class="badge bg-secondary-opacity text-secondary px-3">{{ $kafaClass->display_name }}</span>
                                <span class="badge bg-info-opacity text-info px-3">{{ $subject->name }}</span>
                            </div>
                        </div>

                        <form action="{{ route('exams.results.store') }}" method="POST" id="marksForm">
                            @csrf
                            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                            <input type="hidden" name="kafa_class_id" value="{{ $kafaClass->id }}">
                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">

                            <div class="table-responsive">
                                <table class="rbt-table table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Murid</th>
                                            <th class="text-center" style="width: 150px;">Markah (0-100)</th>
                                            <th class="text-center" style="width: 100px;">TH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $index => $student)
                                        @php $res = $results->get($student->id); @endphp
                                        <tr id="row-{{ $student->id }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <strong>{{ $student->name }}</strong>
                                                    <small class="text-muted" style="font-size: 11px;">{{ $student->mykid }}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" 
                                                       name="marks[{{ $student->id }}]" 
                                                       class="form-control text-center input-mark" 
                                                       value="{{ $res ? $res->marks : '' }}" 
                                                       min="0" max="100" 
                                                       placeholder="0-100" 
                                                       style="height: 50px; font-size: 18px; font-weight: bold;"
                                                       @if($res && $res->is_absent) disabled @endif>
                                            </td>
                                            <td class="text-center">
                                                <div class="rbt-checkbox justify-content-center">
                                                    <input type="checkbox" 
                                                           id="th-{{ $student->id }}"
                                                           name="absent[{{ $student->id }}]" 
                                                           value="1" 
                                                           class="checkbox-absent"
                                                           @if($res && $res->is_absent) checked @endif>
                                                    <label for="th-{{ $student->id }}"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Sticky Save Footer (Patuhi SOP: No Custom CSS, but standard layout) -->
                            <div class="fixed-bottom bg-white border-top shadow-lg p-3" style="z-index: 1050;">
                                <div class="container d-flex justify-content-between align-items-center">
                                    <div class="d-none d-md-block text-muted">
                                        <i class="feather-alert-circle me-1"></i> Pastikan semua markah telah dimasukkan sebelum tekan Simpan.
                                    </div>
                                    <div class="rbt-button-group">
                                        <button type="submit" class="rbt-btn btn-gradient btn-sm hover-icon-reverse">
                                            <span class="icon-reverse-wrapper">
                                                <span class="btn-text">Simpan Markah</span>
                                                <span class="btn-icon"><i class="feather-save"></i></span>
                                                <span class="btn-icon"><i class="feather-save"></i></span>
                                            </span>
                                        </button>
                                        <a href="{{ route('exams.results.show', request()->query()) }}" class="rbt-btn btn-border btn-sm">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-opacity { background: rgba(110, 65, 255, 0.1); color: #6e41ff; }
    .bg-secondary-opacity { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .bg-info-opacity { background: rgba(0, 123, 255, 0.1); color: #007bff; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle TH Checkbox Toggles
    const checkboxes = document.querySelectorAll('.checkbox-absent');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const row = this.closest('tr');
            const markInput = row.querySelector('.input-mark');
            
            if (this.checked) {
                markInput.value = '';
                markInput.disabled = true;
            } else {
                markInput.disabled = false;
                markInput.focus();
            }
        });
    });

    // Handle Form Navigation with fragment (Scroll Retention)
    if (window.location.hash) {
        const id = window.location.hash.substring(1);
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.classList.add('bg-primary-opacity');
            setTimeout(() => {
                el.classList.remove('bg-primary-opacity');
            }, 2000);
        }
    }
});
</script>
@endsection
