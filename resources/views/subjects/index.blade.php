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
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Pengurusan Mata Pelajaran</h4>
                            <div class="rbt-button-group">
                                <a class="rbt-btn btn-gradient btn-sm" href="{{ route('subjects.create') }}">
                                    <i class="feather-plus me-1"></i> Tambah Subjek
                                </a>
                            </div>
                        </div>

                        @role('Super Admin|Pentadbir|Penyelia KAFA')
                        <div class="row mb-4">
                            <div class="col-12">
                                <form action="{{ route('subjects.index') }}" method="GET" class="row g-3 bg-light p-3 rounded align-items-end">
                                    @role('Super Admin|Pentadbir')
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size: 13px; font-weight: 500;">Penapis Daerah</label>
                                        <select name="district_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                            <option value="">Semua Daerah</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endrole
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size: 13px; font-weight: 500;">Penapis Sekolah</label>
                                        <select name="school_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                            <option value="">Semua Sekolah</option>
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('subjects.index') }}" class="rbt-btn btn-sm btn-border" style="height: 38px; line-height: 38px; padding: 0 15px;">Reset Filter</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endrole

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kod</th>
                                        <th>Mata Pelajaran</th>
                                        @role('Super Admin|Pentadbir|Penyelia KAFA')
                                        <th>Sekolah</th>
                                        @endrole
                                        <th class="text-end">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $index => $subject)
                                    <tr id="row-{{ $subject->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge bg-primary-opacity text-primary px-3" style="font-size: 13px;">{{ $subject->code }}</span></td>
                                        <td><strong>{{ $subject->name }}</strong></td>
                                        @role('Super Admin|Pentadbir|Penyelia KAFA')
                                        <td>
                                            @if($subject->school)
                                                <small>{{ $subject->school->name }}</small>
                                            @else
                                                <span class="badge bg-secondary-opacity text-secondary text-uppercase" style="font-size: 10px;">Global</span>
                                            @endif
                                        </td>
                                        @endrole
                                        <td class="text-end">
                                            @php
                                                $canModify = false;
                                                if (auth()->user()->hasAnyRole(['Super Admin', 'Pentadbir'])) {
                                                    $canModify = true;
                                                } elseif (auth()->user()->hasRole('Penyelia KAFA')) {
                                                    if ($subject->school && $subject->school->district_id == auth()->user()->district_id) {
                                                        $canModify = true;
                                                    }
                                                } elseif (auth()->user()->hasAnyRole(['Guru Besar', 'Guru KAFA'])) {
                                                    if ($subject->school_id == auth()->user()->school_id && $subject->school_id !== null) {
                                                        $canModify = true;
                                                    }
                                                }
                                            @endphp

                                            @if($canModify)
                                            <div class="rbt-button-group justify-content-end" style="gap: 5px;">
                                                <a class="rbt-btn btn-xs btn-gradient" href="{{ route('subjects.edit', $subject->id) }}" title="Edit">
                                                    <i class="feather-edit" style="font-size: 14px;"></i>
                                                </a>
                                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" data-delete-form data-name="{{ $subject->name }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rbt-btn btn-xs btn-danger" style="background-color: #dc3545; border-color: #dc3545;" title="Padam">
                                                        <i class="feather-trash-2" style="font-size: 14px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @else
                                                <span class="badge bg-secondary-opacity text-secondary px-3" style="font-size: 11px;">Paparan Sahaja</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($subjects->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center p-5">Tiada data mata pelajaran dijumpai.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-opacity { background: rgba(110, 65, 255, 0.1); color: #6e41ff; }
    .bg-secondary-opacity { background: rgba(108, 117, 125, 0.1); color: #6c757d; }
    .btn-xs {
        padding: 0;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
