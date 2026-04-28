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
                            <h4 class="rbt-title-style-3">Pengurusan Pindah Murid</h4>
                            @role('Guru Besar')
                            <a href="{{ route('student_transfers.create') }}" class="rbt-btn btn-sm btn-gradient">
                                <i class="feather-plus"></i> Permohonan Baru
                            </a>
                            @endrole
                        </div>

                        <div class="rbt-dashboard-table table-responsive mobile-table-750 mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tarikh Mohon</th>
                                        <th>Nama Murid</th>
                                        <th>Sekolah Asal</th>
                                        <th>Sekolah Destinasi</th>
                                        <th>Status</th>
                                        <th class="text-end">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transfers as $index => $transfer)
                                    <tr>
                                        <th>{{ $transfers->firstItem() + $index }}</th>
                                        <td>{{ $transfer->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $transfer->student->name }}</td>
                                        <td>{{ $transfer->fromSchool->name }}</td>
                                        <td>{{ $transfer->toSchool->name }}</td>
                                        <td>
                                            @if($transfer->status == 'pending')
                                                <span class="rbt-badge-5 bg-color-warning-opacity color-warning">Pending</span>
                                            @elseif($transfer->status == 'approved')
                                                <span class="rbt-badge-5 bg-color-success-opacity color-success">Diluluskan</span>
                                            @else
                                                <span class="rbt-badge-5 bg-color-danger-opacity color-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                @if($transfer->status == 'pending')
                                                    @hasanyrole('Super Admin|Penyelia KAFA')
                                                    <form action="{{ route('student_transfers.update', $transfer) }}" method="POST" class="m-0">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="rbt-btn btn-xs btn-border-gradient" title="Luluskan" style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                            <i class="feather-check" style="font-size: 14px; color: var(--color-success);"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('student_transfers.update', $transfer) }}" method="POST" class="m-0">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger" title="Tolak" style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                            <i class="feather-x" style="font-size: 14px;"></i>
                                                        </button>
                                                    </form>
                                                    @endhasanyrole

                                                    @role('Guru Besar')
                                                    @if($transfer->from_school_id == auth()->user()->school_id)
                                                    <form action="{{ route('student_transfers.destroy', $transfer) }}" method="POST" 
                                                          data-delete-form="true" data-name="Permohonan Pindah ({{ $transfer->student->name }})" class="m-0">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger" title="Batal" style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                            <i class="feather-trash-2" style="font-size: 14px;"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @endrole
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">Tiada permohonan pindah murid buat masa ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($transfers->hasPages())
                        <div class="row mt--30">
                            <div class="col-12">
                                {{ $transfers->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
