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
                            <h4 class="rbt-title-style-3">Edit Pengguna</h4>
                        </div>

                        <form action="{{ route('users.update', $user) }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            @method('PATCH')
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="name">Nama Penuh</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="email">Alamat Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="password">Kata Laluan (Biarkan kosong jika tiada perubahan)</label>
                                    <input type="password" id="password" name="password">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="password_confirmation">Sahkan Kata Laluan</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="district_container">
                                <div class="rbt-form-group">
                                    <label for="district_id">Daerah</label>
                                    <select id="district_id" name="district_id" class="form-select">
                                        <option value="">-- Pilih Daerah --</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $user->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="school_container">
                                <div class="rbt-form-group">
                                    <label for="school_id">Sekolah</label>
                                    <select id="school_id" name="school_id" class="form-select">
                                        <option value="">Tiada Sekolah / Pentadbiran & Pembekal</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}" {{ old('school_id', $user->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="rbt-form-group mb--0">
                                    <label class="mb--10">Peranan (Roles)</label>
                                    <div class="row g-2">
                                        @foreach($roles as $role)
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-check p-0 m-0 d-flex align-items-center">
                                                <input class="form-check-input m-0 me-2" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ in_array($role->name, $userRoles) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                                                <label class="form-check-label" for="role_{{ $role->id }}" style="cursor: pointer; line-height: 1;">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt--30">
                                <div class="rbt-button-group">
                                    <button class="rbt-btn btn-gradient" type="submit">Kemaskini Pengguna</button>
                                    <a href="{{ route('users.index') }}" class="rbt-btn btn-border-gradient">Batal</a>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Matikan selectpicker jika ia wujud pada elemen ini
    function destroySelectPicker(id) {
        const el = $(id);
        if (el.length && typeof el.selectpicker === 'function') {
            el.selectpicker('destroy');
            // Paksa gaya paparan jika ia disembunyikan oleh plugin
            el.show().css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1',
                'position': 'relative'
            });
        }
    }

    destroySelectPicker('#district_id');
    destroySelectPicker('#school_id');

    const roleCheckboxes = document.querySelectorAll('input[name="roles[]"]');
    const districtContainer = document.getElementById('district_container');
    const districtSelect = document.getElementById('district_id');
    const schoolContainer = document.getElementById('school_container');
    const schoolSelect = document.getElementById('school_id');

    function toggleFieldsVisibility() {
        let isSupervisor = false;
        let isSchoolRole = false;

        roleCheckboxes.forEach(cb => {
            if (cb.checked) {
                if (cb.value === 'Penyelia KAFA') {
                    isSupervisor = true;
                }
                if (cb.value === 'Guru KAFA' || cb.value === 'Guru Besar') {
                    isSchoolRole = true;
                }
            }
        });

        // Toggle District Visibility (for Supervisor OR School Roles)
        if (isSupervisor || isSchoolRole) {
            districtContainer.style.display = 'block';
            districtSelect.setAttribute('required', 'required');
        } else {
            districtContainer.style.display = 'none';
            districtSelect.removeAttribute('required');
            districtSelect.value = '';
        }

        // Toggle School Visibility (ONLY for School Roles)
        if (isSchoolRole) {
            schoolContainer.style.display = 'block';
            schoolSelect.setAttribute('required', 'required');
        } else {
            schoolContainer.style.display = 'none';
            schoolSelect.removeAttribute('required');
            schoolSelect.value = '';
        }
    }

    roleCheckboxes.forEach(cb => {
        cb.addEventListener('change', toggleFieldsVisibility);
    });

    toggleFieldsVisibility(); // Init on load
});
</script>
@endpush
