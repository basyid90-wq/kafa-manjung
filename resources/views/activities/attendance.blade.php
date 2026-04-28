@extends('layout.layout')

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
                        <div class="section-title d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="rbt-title-style-3">Kehadiran: {{ $activity->name }}</h4>
                                <p class="description mb--0">
                                    <span class="badge bg-{{ $activity->tahap_badge }}">{{ $activity->tahap_label }}</span>
                                    &nbsp; Tandakan murid yang menyertai program ini.
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('activities.save_attendance', $activity) }}" method="POST">
                            @csrf

                            @foreach($students as $groupName => $groupStudents)
                            <div class="mt--25">
                                {{-- Header kumpulan: nama kelas (sekolah) atau nama sekolah (daerah/negeri) --}}
                                <div class="d-flex align-items-center justify-content-between mb--10">
                                    <h6 class="mb--0" style="color: var(--color-primary);">
                                        <i class="feather-users me-1"></i>{{ $groupName }}
                                    </h6>
                                    <small class="text-muted">{{ $groupStudents->count() }} murid</small>
                                </div>
                                <div class="rbt-dashboard-table table-responsive">
                                    <table class="rbt-table table table-borderless mb--0">
                                        <thead>
                                            <tr>
                                                <th style="width:50px;">
                                                    {{-- Checkbox pilih semua dalam kumpulan --}}
                                                    <input type="checkbox" class="select-all-group" style="width:18px;height:18px;"
                                                        data-group="{{ Str::slug($groupName) }}"
                                                        title="Pilih semua">
                                                </th>
                                                <th>No</th>
                                                <th>Nama Murid</th>
                                                @if($activity->tahap !== 'sekolah')
                                                <th>Kelas</th>
                                                @endif
                                                <th>MyKid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($groupStudents as $i => $student)
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                        name="student_ids[]"
                                                        value="{{ $student->id }}"
                                                        class="group-checkbox group-{{ Str::slug($groupName) }}"
                                                        {{ in_array($student->id, $attendedStudentIds) ? 'checked' : '' }}
                                                        style="width:18px;height:18px;">
                                                </td>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $student->name }}</td>
                                                @if($activity->tahap !== 'sekolah')
                                                <td>{{ optional($student->kafaClass)->display_name ?? '-' }}</td>
                                                @endif
                                                <td>{{ $student->mykid }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach

                            <div class="col-12 mt--30">
                                <div class="rbt-button-group justify-content-start">
                                    <button type="submit" class="rbt-btn btn-gradient">Simpan Kehadiran</button>
                                    <a href="{{ route('activities.index') }}" class="rbt-btn btn-border btn-sm">Batal</a>
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
// Checkbox "Pilih Semua" untuk setiap kumpulan
document.querySelectorAll('.select-all-group').forEach(function(selectAll) {
    var group = selectAll.dataset.group;
    var checkboxes = document.querySelectorAll('.group-' + group);

    // Set state awal
    selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
    selectAll.indeterminate = !selectAll.checked && Array.from(checkboxes).some(cb => cb.checked);

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    checkboxes.forEach(function(cb) {
        cb.addEventListener('change', function() {
            selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.indeterminate = !selectAll.checked && Array.from(checkboxes).some(cb => cb.checked);
        });
    });
});
</script>
@endsection
