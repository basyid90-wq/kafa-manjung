@extends('layout.layout')

@php $bodyClass = ''; $footer = 'true'; @endphp

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

@php
use App\Services\ExamService;
$examService = app(ExamService::class);

$formSlotLabels = [
    'tilawah_tahfiz' => 'Tilawah & Tahfiz Al-Quran',
    'lughati'        => 'Lughati',
    'ibadah'         => 'Ibadah',
    'akidah'         => 'Akidah',
    'sirah'          => 'Sirah & Tamadun Islam',
    'adab'           => 'Adab & Akhlak',
    'jawi_khat'      => 'Jawi & Khat',
    'bahasa_arab'    => 'Bahasa Arab',
    'amali_solat'    => 'Amali Solat',
];

$allSlots = array_keys($formSlotLabels);
@endphp

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">Rekod Pencapaian — {{ $achievement->student->name }}</h4>
                            <div>
                                <a href="javascript:void(0);" onclick="openPdfBlob(this, '{{ route('achievements.pdf', $achievement->id) }}')"
                                   class="rbt-btn btn-gradient btn-sm hover-icon-reverse">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Cetak PDF</span>
                                        <span class="btn-icon"><i class="feather-printer"></i></span>
                                        <span class="btn-icon"><i class="feather-printer"></i></span>
                                    </span>
                                </a>
                                <a href="{{ route('achievements.index') }}" class="rbt-btn btn-border btn-sm ms-2">Kembali</a>
                            </div>
                        </div>

                        {{-- Maklumat Murid --}}
                        <div class="row mb--20" style="background:#f8f9fa;padding:14px;border-radius:8px;">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nama:</strong> {{ $achievement->student->name }}</p>
                                <p class="mb-1"><strong>Nama Jawi:</strong> {{ $achievement->student->jawi_name ?? '-' }}</p>
                                <p class="mb-1"><strong>No. Kad Pengenalan:</strong> {{ $achievement->student->mykid }}</p>
                                <p class="mb-1"><strong>Kelas:</strong> {{ $achievement->kafaClass->name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Sekolah:</strong> {{ $achievement->school->name ?? '-' }}</p>
                                <p class="mb-1"><strong>Tahun Akademik:</strong> {{ $achievement->academic_year }}</p>
                                <p class="mb-1"><strong>Status:</strong>
                                    @if($achievement->status === 'final')
                                        <span class="badge bg-success">Final</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Draf</span>
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Kedudukan Kelas:</strong>
                                    {{ $achievement->class_rank ?? '-' }} / {{ $achievement->total_in_class ?? '-' }}
                                </p>
                                <p class="mb-1"><strong>Kedudukan Darjah:</strong>
                                    {{ $achievement->grade_rank ?? '-' }} / {{ $achievement->total_in_grade ?? '-' }}
                                </p>
                            </div>
                        </div>

                        {{-- Markah --}}
                        <div class="table-responsive">
                            <table class="rbt-table table table-bordered table-sm" style="font-size:13px;">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Pertengahan Tahun</th>
                                        <th>Akhir Tahun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allSlots as $i => $slot)
                                    @php
                                        $midR = $midResults->get($slot);
                                        $endR = $endResults->get($slot);
                                        $midVal = $midR
                                            ? ($midR->is_absent ? 'TH' : $examService->formatMark($midR->marks))
                                            : '-';
                                        $endVal = $endR
                                            ? ($endR->is_absent ? 'TH' : $examService->formatMark($endR->marks))
                                            : '-';
                                    @endphp
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $formSlotLabels[$slot] }}</td>
                                        <td>{{ $midVal }}</td>
                                        <td>{{ $endVal }}</td>
                                    </tr>
                                    @endforeach

                                    {{-- PHCI --}}
                                    <tr>
                                        <td>{{ count($allSlots) + 1 }}</td>
                                        <td>Penghayatan Cara Hidup Islam (PHCI)</td>
                                        <td>
                                            @if($achievement->phci_midyear !== null)
                                                {{ $examService->formatMark($achievement->phci_midyear) }}
                                            @else -
                                            @endif
                                        </td>
                                        <td>
                                            @if($achievement->phci_endyear !== null)
                                                {{ $examService->formatMark($achievement->phci_endyear) }}
                                            @else -
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Lain-lain --}}
                        <div class="row mt--20">
                            <div class="col-md-3">
                                <p><strong>Kelakuan:</strong> {{ $achievement->kelakuan ?? '-' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Kebersihan:</strong> {{ $achievement->kebersihan ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Ulasan Guru:</strong> {{ $achievement->teacher_comments ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
