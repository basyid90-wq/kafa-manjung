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
                    
                    /* Fix untuk dropdown naik ke atas dan terpotong */
                    .rbt-dashboard-content, .content { overflow: visible !important; }
                    .nice-select .list { max-height: 250px; overflow-y: auto !important; }
                    .nice-select.open .list { top: 100%; bottom: auto; } /* Paksa buka ke bawah */
                </style>
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center mb--20">
                            <h4 class="rbt-title-style-3">
                                @if(isset($school))
                                    Rekod Pencapaian Murid - {{ $school->name }}
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

                        {{-- Filter --}}
                        <form method="GET" action="{{ route('achievements.index') }}" class="row g-2 mb--20">
                            <div class="col-md-4">
                                <select name="kafa_class_id" class="form-select">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach($classes as $kelas)
                                        <option value="{{ $kelas->id }}" {{ request('kafa_class_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="academic_year" class="form-select">
                                    <option value="">-- Semua Tahun --</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y }}" {{ request('academic_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
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
                                    <tr id="row-{{ $rec->id }}">
                                        <td>{{ $records->firstItem() + $i }}</td>
                                        <td>{{ $rec->student->name ?? '-' }}</td>
                                        <td>{{ $rec->kafaClass->name ?? '-' }}</td>
                                        <td>{{ $rec->academic_year }}</td>
                                        <td>
                                            @if($rec->status === 'final')
                                                <span class="badge bg-success">Final</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draf</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('achievements.show', ['achievement' => $rec->id, 'page' => $records->currentPage()]) }}" class="rbt-btn-link" title="Lihat"><i class="feather-eye"></i></a>
                                            @hasanyrole('Guru Besar|Guru KAFA|Super Admin')
                                            <a href="{{ route('achievements.edit', ['achievement' => $rec->id, 'page' => $records->currentPage()]) }}" class="rbt-btn-link ms-2" title="Kemaskini"><i class="feather-edit-2"></i></a>
                                            @endhasanyrole
                                            <a href="javascript:void(0);" onclick="openPdfBlob(this, '{{ route('achievements.pdf', $rec->id) }}')" class="rbt-btn-link ms-2" title="Cetak PDF"><i class="feather-printer"></i></a>
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
