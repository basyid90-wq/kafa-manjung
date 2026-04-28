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

                        {{-- Header --}}
                        <div class="section-title d-flex justify-content-between align-items-start mb--30 flex-wrap gap-2">
                            <div>
                                <h4 class="rbt-title-style-3">{{ $activity->name }}</h4>
                                <p class="color-body mb-0" style="font-size:0.88em;">
                                    <i class="feather-calendar me-1"></i>{{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y') }}
                                    &nbsp;|&nbsp;
                                    <i class="feather-home me-1"></i>{{ $activity->school->name ?? '—' }}
                                    &nbsp;|&nbsp;
                                    <i class="feather-users me-1"></i>{{ $attendedStudents->count() }} peserta hadir
                                </p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                {{-- Pentadbir TIDAK boleh jana sijil atau rekod kehadiran --}}
                                @hasanyrole('Super Admin|Penyelia KAFA|Guru Besar|Guru KAFA')
                                <button type="button" class="rbt-btn btn-gradient btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalSijil">
                                    <i class="feather-award me-1"></i>Jana Sijil Pukal
                                </button>
                                <a href="{{ route('activities.attendance', $activity) }}"
                                   class="rbt-btn btn-border-gradient btn-sm">
                                    <i class="feather-check-square me-1"></i>Kehadiran
                                </a>
                                @endhasanyrole
                                <a href="{{ route('activities.index') }}" class="rbt-btn btn-border-gradient btn-sm">
                                    <i class="feather-arrow-left me-1"></i>Kembali
                                </a>
                            </div>
                        </div>

                        @if($activity->photo_path)
                        <div class="mb--25">
                            <img src="{{ asset('storage/' . $activity->photo_path) }}" alt="{{ $activity->name }}"
                                 style="max-height:260px;object-fit:cover;border-radius:10px;width:100%;">
                        </div>
                        @endif

                        @if($activity->description)
                        <p class="color-body mb--25" style="line-height:1.8;">{{ $activity->description }}</p>
                        @endif

                        {{-- Senarai Peserta --}}
                        <div class="section-title mb--15">
                            <h6 class="rbt-title-style-2">Senarai Peserta</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelajar</th>
                                        <th>Kelas</th>
                                        <th>No. Sijil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendedStudents as $i => $student)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <strong>{{ $student->name }}</strong>
                                            @if($student->jawi_name)
                                            <div class="color-body" dir="rtl" style="font-family:'Lateef',serif;font-size:1em;">{{ $student->jawi_name }}</div>
                                            @endif
                                        </td>
                                        <td class="color-body">{{ $student->kafaClass->display_name ?? '—' }}</td>
                                        <td class="color-body" style="font-size:0.82em;">
                                            {{ $student->certificates->first()?->reference_no ?? '—' }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center color-body">
                                            Tiada peserta dicatat. <a href="{{ route('activities.attendance', $activity) }}">Rekod kehadiran dahulu.</a>
                                        </td>
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

{{-- Modal Jana Sijil Pukal --}}
<div class="modal fade" id="modalSijil" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="feather-award me-2"></i>Jana Sijil Pukal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($templates->isEmpty())
                    <div class="text-center py-3">
                        <i class="feather-alert-circle" style="font-size:2rem;color:#ffc107;"></i>
                        <p class="mt-2 color-body">Tiada templat sijil tersedia.<br>
                            <a href="{{ route('certificates.templates.create') }}">Buat templat baharu</a>
                        </p>
                    </div>
                @else
                    <p class="color-body" style="font-size:0.9em;">
                        Sijil akan dijana bagi <strong>{{ $attendedStudents->count() }} peserta</strong> yang hadir.
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Templat Sijil</label>
                        <select id="selectTemplate" class="form-select selectpicker" data-style="btn-default" style="height:50px;">
                            @foreach($templates as $t)
                            <option value="{{ $t->id }}">{{ $t->name }} ({{ ucfirst($t->level) }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="rbt-btn btn-border-gradient btn-sm" data-bs-dismiss="modal">Batal</button>
                @if($templates->isNotEmpty() && $attendedStudents->isNotEmpty())
                <button type="button" id="btnJanaSijil" class="rbt-btn btn-gradient btn-sm">
                    <i class="feather-download me-1"></i>Jana & Pratonton PDF
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btnJana = document.getElementById('btnJanaSijil');
    if (!btnJana) return;

    btnJana.addEventListener('click', function () {
        var templateId = document.getElementById('selectTemplate').value;
        if (!templateId) return;

        btnJana.disabled = true;
        btnJana.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menjana...';

        fetch('{{ route("certificates.bulk.generate", $activity) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ certificate_template_id: templateId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.pdf) {
                renderPdfBase64(data.pdf);
            } else {
                alert('Ralat menjana sijil.');
            }
        })
        .catch(() => alert('Ralat sambungan.'))
        .finally(() => {
            btnJana.disabled = false;
            btnJana.innerHTML = '<i class="feather-download me-1"></i>Jana & Pratonton PDF';
        });
    });
});
</script>
@endpush
@endsection
