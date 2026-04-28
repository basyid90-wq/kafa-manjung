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
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Rekod Kesalahan Disiplin</h4>
                        </div>
                        
                        <form action="{{ route('disciplinary.store') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="student_id">Pilih Murid</label>
                                    <select name="student_id" id="student_id" class="rbt-big-select" required>
                                        <option value="">-- Pilih Murid --</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->mykid }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="date">Tarikh Kejadian</label>
                                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="offense_details">Butiran Kesalahan</label>
                                    <textarea name="offense_details" id="offense_details" rows="5" placeholder="Terangkan kesalahan murid secara terperinci..." required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="action_taken">Tindakan Diambil</label>
                                    <input type="text" name="action_taken" id="action_taken" placeholder="Contoh: Amaran Pertama, Sesi Kaunseling..." required>
                                </div>
                            </div>
                            <div class="col-12 mt--20">
                                <div class="rbt-button-group justify-content-start">
                                    <button type="submit" class="rbt-btn btn-gradient">Simpan Rekod</button>
                                    <a href="{{ route('disciplinary.index') }}" class="rbt-btn btn-border btn-sm">Batal</a>
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
