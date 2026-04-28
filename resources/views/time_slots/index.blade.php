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
                            <h4 class="rbt-title-style-3">Set Waktu Mengajar</h4>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Form Tambah Slot -->
                        <div class="rbt-profile-row rbt-default-form mb--40">
                            <form action="{{ route('time_slots.store') }}" method="POST" class="row row--15">
                                @csrf
                                <div class="col-lg-4">
                                    <div class="rbt-form-group">
                                        <label>Nama Slot (cth: Waktu 1)</label>
                                        <input type="text" name="name" placeholder="Waktu 1" style="height: 50px;" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="rbt-form-group">
                                        <label>Masa Mula</label>
                                        <input type="time" name="start_time" style="height: 50px;" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="rbt-form-group">
                                        <label>Masa Tamat</label>
                                        <input type="time" name="end_time" style="height: 50px;" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="rbt-form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="rbt-btn btn-gradient btn-sm w-100" style="height: 50px;">Tambah</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <hr class="mb--40">

                        <!-- Senarai Slot -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-color-primary-opacity">
                                    <tr>
                                        <th>Nama Slot</th>
                                        <th>Masa Mula</th>
                                        <th>Masa Tamat</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($slots as $slot)
                                        <tr>
                                            <form action="{{ route('time_slots.update', $slot) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td>
                                                    <input type="text" name="name" value="{{ $slot->name }}" class="form-control" style="height: 50px;" required>
                                                </td>
                                                <td>
                                                    <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}" class="form-control" style="height: 50px;" required>
                                                </td>
                                                <td>
                                                    <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}" class="form-control" style="height: 50px;" required>
                                                </td>
                                                <td class="d-flex gap-2">
                                                    <button type="submit" class="rbt-btn btn-gradient btn-sm" title="Simpan"><i class="feather-save"></i></button>
                                                    </form>
                                                    <form action="{{ route('time_slots.destroy', $slot) }}" method="POST" onsubmit="return confirm('Padam slot ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rbt-btn btn-pink btn-sm" title="Padam"><i class="feather-trash-2"></i></button>
                                                    </form>
                                                </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tiada slot masa ditetapkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple scroll retention
    window.onload = function() {
        if (localStorage.getItem('scrollPosition')) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
        }
    };
    window.onscroll = function() {
        localStorage.setItem('scrollPosition', window.scrollY);
    };
</script>
@endsection
