@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Edit Pengguna</h1>
            <p class="ek-page-sub mt-1">{{ $user->name }}</p>
        </div>
        <a href="{{ route('users.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="ek-label">Nama Penuh <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Kata Laluan <span class="text-xs text-gray-400">(Biarkan kosong jika tiada perubahan)</span></label>
                    <input type="password" name="password"
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Sahkan Kata Laluan</label>
                    <input type="password" name="password_confirmation"
                           class="ek-input">
                </div>

                <div id="school_container" class="hidden">
                    <label class="ek-label">Sekolah</label>
                    <select id="school_id" name="school_id"
                            class="ek-input">
                        <option value="">Tiada Sekolah (Super Admin sahaja)</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id', $user->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Roles --}}
            <div class="mb-5">
                <label class="ek-label">Peranan (Roles)</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
                    @foreach($roles as $role)
                    <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}"
                               {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700">{{ $role->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Kemaskini Pengguna
                </button>
                <a href="{{ route('users.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleCheckboxes    = document.querySelectorAll('input[name="roles[]"]');
    const schoolContainer   = document.getElementById('school_container');
    const schoolSelect      = document.getElementById('school_id');

    function toggleFieldsVisibility() {
        let isSchoolRole = false;
        roleCheckboxes.forEach(cb => {
            if (cb.checked) {
                if (cb.value === 'Guru KAFA' || cb.value === 'Guru Besar') isSchoolRole = true;
            }
        });
        if (isSchoolRole) {
            schoolContainer.classList.remove('hidden');
            schoolSelect.setAttribute('required', 'required');
        } else {
            schoolContainer.classList.add('hidden');
            schoolSelect.removeAttribute('required');
            schoolSelect.value = '';
        }
    }

    roleCheckboxes.forEach(cb => cb.addEventListener('change', toggleFieldsVisibility));
    toggleFieldsVisibility();
});
</script>
@endsection
