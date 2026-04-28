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
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Bank Templat Sijil Digital</h4>
                            <a href="{{ route('certificates.templates.create') }}" class="rbt-btn btn-gradient btn-sm">
                                <i class="feather-plus me-1"></i>Tambah Templat
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Templat</th>
                                        <th>Peringkat</th>
                                        <th>Susun Atur</th>
                                        <th>Sekolah / Daerah</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($templates as $i => $t)
                                    <tr id="row-{{ $t->id }}">
                                        <td>{{ $templates->firstItem() + $i }}</td>
                                        <td><strong>{{ $t->name }}</strong></td>
                                        <td>
                                            <span class="rbt-badge-5 {{ $t->level === 'daerah' ? 'bg-primary-opacity color-primary' : 'bg-success-opacity color-success' }}">
                                                {{ ucfirst($t->level) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($t->layout_style) }}</td>
                                        <td class="color-body" style="font-size:0.85em;">
                                            {{ $t->school->name ?? $t->district->name ?? '—' }}
                                        </td>
                                        <td>
                                            <form method="POST"
                                                  action="{{ route('certificates.templates.destroy', $t) }}"
                                                  data-delete-form
                                                  data-name="{{ $t->name }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rbt-btn btn-xs btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                        style="width:35px;height:35px;" title="Padam">
                                                    <i class="feather-trash-2" style="font-size:14px;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center color-body">Tiada templat sijil didaftarkan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt--20">{{ $templates->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
