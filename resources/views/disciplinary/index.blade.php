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
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <h4 class="rbt-title-style-3">Rekod Disiplin Murid</h4>
                            @role('Super Admin|Pentadbir|Guru KAFA')
                            <a href="{{ route('disciplinary.create') }}" class="rbt-btn btn-gradient btn-sm">Rekod Kesalahan Baru</a>
                            @endrole
                        </div>

                        <div class="rbt-dashboard-table table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Murid</th>
                                        <th>Tarikh</th>
                                        <th>Kesalahan</th>
                                        <th>Tindakan Diambil</th>
                                        <th>Dilapor Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $record)
                                    <tr>
                                        <td>{{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</td>
                                        <td>{{ $record->student->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                                        <td>{{ Str::limit($record->offense_details, 50) }}</td>
                                        <td><span class="rbt-badge-5 bg-danger-opacity">{{ $record->action_taken }}</span></td>
                                        <td>{{ $record->reporter->name }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tiada rekod disiplin.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt--20">
                            <div class="col-lg-12">
                                {{ $records->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
