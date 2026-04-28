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
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Tambah Rekod Kewangan</h4>
                        </div>

                        <form action="{{ route('financial.store') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="transaction_type">Jenis Transaksi</label>
                                    <select id="transaction_type" name="transaction_type" class="rbt-big-select" required>
                                        <option value="in">Wang Masuk (+)</option>
                                        <option value="out">Wang Keluar (-)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="account_category_id">Kategori Akaun</label>
                                    <select id="account_category_id" name="account_category_id" class="rbt-big-select" required>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="amount">Jumlah (RM)</label>
                                    <input type="number" step="0.01" id="amount" name="amount" placeholder="0.00" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="transaction_date">Tarikh Transaksi</label>
                                    <input type="date" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="rbt-form-group">
                                    <label for="reference_no">No. Rujukan / Resit</label>
                                    <input type="text" id="reference_no" name="reference_no" placeholder="Masukkan no rujukan jika ada">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="rbt-form-group">
                                    <label for="description">Keterangan / Catatan</label>
                                    <textarea id="description" name="description" placeholder="Catatan tambahan..."></textarea>
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <button class="rbt-btn btn-gradient" type="submit">Simpan Rekod</button>
                                    <a href="{{ route('financial.index') }}" class="rbt-btn btn-border-gradient">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
