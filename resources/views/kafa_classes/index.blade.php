@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
@endphp

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
                            <h4 class="rbt-title-style-3">Pengurusan Kelas</h4>
                            <a href="{{ route('kafa_classes.create') }}" class="rbt-btn btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Tambah Kelas</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                        </div>

                        <!-- Professional Notice -->
                        <div class="rbt-info-notice alert bg-primary-opacity d-flex align-items-center gap-4 p-4 rounded-3 mt--30 mb--30" style="border: 1px solid rgba(110, 65, 255, 0.1); border-left: 5px solid var(--color-primary); background: linear-gradient(90deg, rgba(110, 65, 255, 0.08) 0%, rgba(110, 65, 255, 0.02) 100%) !important;">
                            <div class="icon-wrapper bg-white rounded-circle d-flex align-items-center justify-content-center" style="min-width: 50px; height: 50px; box-shadow: 0 4px 15px rgba(110, 65, 255, 0.15);">
                                <i class="feather-bell text-primary" style="font-size: 24px; color: var(--color-primary) !important;"></i>
                            </div>
                            <div class="notice-text">
                                <h6 class="mb-1" style="color: var(--color-primary); font-weight: 700; letter-spacing: 0.5px; font-size: 14px;">MAKLUMAN PENTING (WAJIB BACA)</h6>
                                <p class="mb-0" style="font-size: 15px; line-height: 1.6; color: var(--color-heading);">
                                    Bagi memudahkan urusan <strong>IMPORT</strong> data murid, pastikan <strong>Nama Kelas</strong> adalah <strong style="text-transform: uppercase;">TEPAT DAN SAMA</strong> seperti yang didaftarkan dalam <strong>Sistem SIMPENI Jakim</strong>.
                                </p>
                            </div>
                        </div>

                        <div class="table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kelas & Tahun</th>
                                        <th>Guru Kelas</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $c)
                                    <tr>
                                        <td>{{ ($classes->currentPage() - 1) * $classes->perPage() + $loop->iteration }}</td>
                                        <td>{{ $c->display_name }}</td>
                                        <td>
                                            @if($c->teacher)
                                                <span class="badge bg-primary-opacity">{{ $c->teacher->name }}</span>
                                            @else
                                                <span class="text-muted">Tiada Guru</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('kafa_classes.edit', $c) }}" class="rbt-btn btn-xs btn-border-gradient" title="Edit" style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                    <i class="feather-edit" style="font-size: 14px;"></i>
                                                </a>
                                                <form action="{{ route('kafa_classes.destroy', $c) }}" method="POST"
                                                      data-delete-form data-name="{{ $c->display_name }}" style="margin: 0;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger" title="Padam" style="height: 35px; width: 35px; padding: 0; display: flex; align-items: center; justify-content: center; min-width: 35px;">
                                                        <i class="feather-trash-2" style="font-size: 14px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tiada rekod.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt--20">
                            <div class="col-lg-12">
                                {{ $classes->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
