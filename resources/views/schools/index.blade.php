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
                            <h4 class="rbt-title-style-3">Pengurusan Sekolah</h4>
                            @unlessrole('Guru Besar')
                            <a href="{{ route('schools.create') }}" class="rbt-btn btn-sm hover-icon-reverse">
                                 <span class="icon-reverse-wrapper">
                                     <span class="btn-text">Tambah Sekolah</span>
                                     <span class="btn-icon"><i class="feather-plus"></i></span>
                                     <span class="btn-icon"><i class="feather-plus"></i></span>
                                 </span>
                            </a>
                            @endunlessrole
                        </div>


                        <div class="table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sekolah</th>
                                        <th>Daerah</th>
                                        <th>Kod Sekolah</th>
                                        <th>No. Telefon</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schools as $school)
                                    <tr>
                                        <td>{{ ($schools->currentPage() - 1) * $schools->perPage() + $loop->iteration }}</td>
                                        <td>{{ $school->name }}</td>
                                        <td><span class="rbt-badge-5 bg-primary-opacity">{{ $school->district->name }}</span></td>
                                        <td><code>{{ $school->code }}</code></td>
                                        <td>{{ $school->no_telefon ?? '-' }}</td>
                                        <td>
                                            <div class="rbt-button-group justify-content-start">
                                                <a href="{{ route('schools.edit', $school) }}" class="rbt-btn btn-xs btn-border-gradient" title="Edit">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                @unlessrole('Guru Besar')
                                                <form action="{{ route('schools.destroy', $school) }}" method="POST"
                                                      data-delete-form data-name="{{ $school->name }}">
                                                     @csrf @method('DELETE')
                                                     <button type="submit" class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger" title="Padam">
                                                         <i class="feather-trash-2"></i>
                                                     </button>
                                                 </form>
                                                 @endunlessrole
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt--20">
                            <div class="col-lg-12">
                                {{ $schools->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
