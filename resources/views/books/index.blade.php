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
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <h4 class="rbt-title-style-3">Katalog Buku KAFA</h4>
                            @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                            <a href="{{ route('books.create') }}" class="rbt-btn btn-gradient btn-sm hover-icon-reverse">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Tambah Buku Baru</span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                    <span class="btn-icon"><i class="feather-plus"></i></span>
                                </span>
                            </a>
                            @endhasanyrole
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="rbt-dashboard-table table-responsive mt--30">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Buku</th>
                                        <th>Tahun/Darjah</th>
                                        <th class="text-center">Harga (RM)</th>
                                        @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                                        <th>Tindakan</th>
                                        @endhasanyrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($books as $book)
                                    <tr id="row-{{ $book->id }}">
                                        <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                                        <td>{{ $book->name }}</td>
                                        <td>{{ $book->tahun_darjah ?? '-' }}</td>
                                        <td class="text-center">{{ number_format($book->price, 2) }}</td>
                                        @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('books.edit', $book) }}"
                                                   class="rbt-btn btn-xs btn-border-gradient p-0 d-flex align-items-center justify-content-center"
                                                   style="width:35px;height:35px;" title="Edit">
                                                    <i class="feather-edit" style="font-size:14px;"></i>
                                                </a>
                                                <form action="{{ route('books.destroy', $book) }}" method="POST"
                                                      data-delete-form data-name="{{ $book->name }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="rbt-btn btn-xs btn-border-gradient btn-gradient-danger p-0 d-flex align-items-center justify-content-center"
                                                            style="width:35px;height:35px;" title="Padam">
                                                        <i class="feather-trash-2" style="font-size:14px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        @endhasanyrole
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Tiada buku dalam katalog.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt--20">
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
