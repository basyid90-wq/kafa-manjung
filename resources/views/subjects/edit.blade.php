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
                        <div class="section-title mb--30">
                            <h4 class="rbt-title-style-3">Kemaskini Mata Pelajaran</h4>
                        </div>

                        <form action="{{ route('subjects.update', $subject->id) }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="page" value="{{ request('page', 1) }}">

                            <div class="col-lg-8">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Mata Pelajaran</label>
                                    <input type="text" id="name" name="name" value="{{ $subject->name }}" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="rbt-form-group">
                                    <label for="code">Kod Subjek</label>
                                    <input type="text" id="code" name="code" value="{{ $subject->code }}" required>
                                </div>
                            </div>

                            @role('Super Admin|Pentadbir|Penyelia KAFA')
                            <div class="col-lg-8">
                                <div class="rbt-form-group">
                                    <label for="school_id">Sekolah (Pilihan: Kosongkan untuk Global)</label>
                                    <select id="school_id" name="school_id" class="rbt-big-select">
                                        <option value="">-- Subjek Global --</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}" {{ $subject->school_id == $school->id ? 'selected' : '' }}>
                                                {{ $school->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole

                            @php
                            $formSlots = [
                                'tilawah_tahfiz' => 'Tilawah & Tahfiz Al-Quran',
                                'lughati'        => 'Lughati (Lughatul Quran)',
                                'ibadah'         => 'Ibadah',
                                'akidah'         => 'Akidah',
                                'sirah'          => 'Sirah & Tamadun Islam',
                                'adab'           => 'Adab & Akhlak',
                                'jawi_khat'      => 'Jawi & Khat',
                                'bahasa_arab'    => 'Bahasa Arab',
                                'amali_solat'    => 'Amali Solat',
                            ];
                            @endphp
                            <div class="col-lg-4">
                                <div class="rbt-form-group">
                                    <label for="form_slot">Slot Borang Pencapaian</label>
                                    <select id="form_slot" name="form_slot" class="rbt-big-select">
                                        <option value="">-- Tiada --</option>
                                        @foreach($formSlots as $key => $label)
                                            <option value="{{ $key }}" {{ $subject->form_slot === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="rbt-form-group">
                                    <button class="rbt-btn btn-gradient" type="submit">Kemaskini Rekod</button>
                                    <a class="rbt-btn btn-border" href="{{ route('subjects.index', ['page' => request('page', 1)]) }}">Batal</a>
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
