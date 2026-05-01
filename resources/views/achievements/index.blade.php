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
                <style>
                    @font-face { font-family:'Lateef'; src:url('/fonts/Lateef-Regular.ttf') format('truetype'); }
                    .jawi-cell { font-family:'Lateef',serif; font-size:1.1em; direction:rtl; text-align:right; }
                    .rbt-dashboard-content, .content { overflow: visible !important; }
                    .nice-select .list { max-height: 250px; overflow-y: auto !important; }
                    .nice-select.open .list { top: 100%; bottom: auto; }
                </style>
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">
                                @if(isset($school))
                                    Rekod Pencapaian Murid — {{ $school->name }}
                                @else
                                    Rekod Pencapaian Murid
                                @endif
                            </h4>
                            @hasanyrole('Guru Besar|Guru KAFA')
                            <a href="{{ route('achievements.create') }}" class="rbt-btn btn-gradient btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Tambah Rekod</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                            @endhasanyrole
                        </div>

                        {{-- Completion stats for Guru Besar --}}
                        @hasrole('Guru Besar')
                        @if(isset($completionStats) && $completionStats->isNotEmpty())
                        <div class="rbt-shadow-box p--15 mb--25" style="background:#f8f9fa;">
                            <p class="fw-bold mb--10" style="font-size:13px;"><i class="feather-bar-chart-2 me-1"></i> Status Rekod Mengikut Kelas ({{ request('academic_year', date('Y')) }})</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0" style="font-size:12px;">
                                    <thead><tr class="text-muted">
                                        <th>Kelas</th>
                                        <th class="text-center">Murid</th>
                                        <th class="text-center">Direkod</th>
                                        <th class="text-center">Final</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Finalisasi</th>
                                    </tr></thead>
                                    <tbody>
                                        @foreach($completionStats as $cls)
                                        @php
                                            $pct = $cls->students_count > 0 ? round(($cls->recorded_count / $cls->students_count) * 100) : 0;
                                            $allFinal = $cls->recorded_count > 0 && $cls->final_count === $cls->recorded_count;
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $cls->name }}</strong></td>
                                            <td class="text-center">{{ $cls->students_count }}</td>
                                            <td class="text-center">{{ $cls->recorded_count }}</td>
                                            <td class="text-center">{{ $cls->final_count }}</td>
                                            <td class="text-center">
                                                @if($cls->recorded_count === 0)
                                                    <span class="badge bg-danger">Belum Rekod</span>
                                                @elseif($allFinal)
                                                    <span class="badge bg-success">Semua Final</span>
                                                @else
                                                    <div class="progress" style="height:6px; max-width:80px; margin:auto;">
                                                        <div class="progress-bar {{ $pct >= 80 ? 'bg-success' : 'bg-warning' }}" style="width:{{ $pct }}%"></div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($cls->recorded_count > 0 && !$allFinal)
                                                <form method="POST" action="{{ route('achievements.bulk_finalize') }}" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="kafa_class_id" value="{{ $cls->id }}">
                                                    <input type="hidden" name="academic_year" value="{{ request('academic_year', date('Y')) }}">
                                                    <button type="submit" class="rbt-btn btn-xs btn-border"
                                                        onclick="return confirm('Finalkan semua rekod draf kelas {{ $cls->name }}?')"
                                                        title="Finalkan Semua Draf">
                                                        <i class="feather-check-square"></i> Final
                                                    </button>
                                                </form>
                                                @elseif($allFinal)
                                                    <span class="text-success" style="font-size:12px;"><i class="feather-check-circle"></i></span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @endhasrole

                        {{-- Filter --}}
                        <form method="GET" action="{{ isset($school) ? route('achievements.school_list', $school->id) : route('achievements.index') }}" class="row g-2 mb--20">
                            <div class="col-md-3">
                                <select name="kafa_class_id" class="form-select form-select-sm">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach($classes as $kelas)
                                        <option value="{{ $kelas->id }}" {{ request('kafa_class_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="academic_year" class="form-select form-select-sm">
                                    <option value="">-- Semua Tahun --</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y }}" {{ request('academic_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select form-select-sm">
                                    <option value="">-- Semua Status --</option>
                                    <option value="draft"  {{ request('status') === 'draft'  ? 'selected' : '' }}>Draf</option>
                                    <option value="final"  {{ request('status') === 'final'  ? 'selected' : '' }}>Final</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="rbt-btn btn-border btn-sm w-100">Tapis</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ isset($school) ? route('achievements.school_list', $school->id) : route('achievements.index') }}" class="rbt-btn btn-sm w-100" style="background:#eee;color:#333">Set Semula</a>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Murid</th>
                                        <th>Kelas</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $i => $rec)
                                    @php $isFinal = $rec->status === 'final'; @endphp
                                    <tr id="row-{{ $rec->id }}" class="{{ $isFinal ? '' : 'table-warning bg-opacity-10' }}">
                                        <td>{{ $records->firstItem() + $i }}</td>
                                        <td>{{ $rec->student->name ?? '-' }}</td>
                                        <td>{{ $rec->kafaClass->name ?? '-' }}</td>
                                        <td>{{ $rec->academic_year }}</td>
                                        <td>
                                            @if($isFinal)
                                                <span class="badge bg-success"><i class="feather-lock" style="font-size:10px;"></i> Final</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draf</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('achievements.show', ['achievement' => $rec->id, 'page' => $records->currentPage()]) }}"
                                               class="rbt-btn-link" title="Lihat"><i class="feather-eye"></i></a>

                                            @hasanyrole('Guru Besar|Guru KAFA|Super Admin')
                                            @if(!$isFinal || auth()->user()->hasAnyRole(['Guru Besar', 'Super Admin']))
                                            <a href="{{ route('achievements.edit', ['achievement' => $rec->id, 'page' => $records->currentPage()]) }}"
                                               class="rbt-btn-link ms-2" title="Kemaskini"><i class="feather-edit-2"></i></a>
                                            @else
                                            <span class="ms-2 text-muted" title="Rekod dikunci (Final)"><i class="feather-lock" style="font-size:13px;"></i></span>
                                            @endif
                                            @endhasanyrole

                                            {{-- Unlock button — Guru Besar only --}}
                                            @hasanyrole('Guru Besar|Super Admin')
                                            @if($isFinal)
                                            <form method="POST" action="{{ route('achievements.unlock', $rec->id) }}" style="display:inline;"
                                                  onsubmit="return confirm('Buka semula rekod {{ $rec->student->name ?? '' }} sebagai Draf?')">
                                                @csrf
                                                <button type="submit" class="rbt-btn-link ms-2 border-0 bg-transparent p-0"
                                                        title="Buka Semula (Draf)" style="color:#fd7e14;">
                                                    <i class="feather-unlock" style="font-size:13px;"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @endhasanyrole

                                            <a href="javascript:void(0);"
                                               onclick="openPdfBlob(this, '{{ route('achievements.pdf', $rec->id) }}')"
                                               class="rbt-btn-link ms-2" title="Cetak PDF">
                                               <i class="feather-printer"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted">Tiada rekod pencapaian.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--20">
                            {{ $records->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
