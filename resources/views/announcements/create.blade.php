@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Cipta Hebahan Baru</h1>
        </div>
        <a href="{{ route('announcements.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form action="{{ route('announcements.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="ek-label">Tajuk Hebahan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Tajuk pengumuman..." required
                           class="ek-input">
                </div>
                <div>
                    <label class="ek-label">Kategori</label>
                    <select name="category"
                            class="ek-input">
                        @foreach(['Mesyuarat','Taklimat','Kursus','Pekeliling','Lain-lain'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="ek-label">Sasaran Role <span class="text-red-500">*</span></label>
                    <select name="target_role" required
                            class="ek-input">
                        <option value="Semua">Semua Guru</option>
                        @role('Super Admin')
                        <option value="Guru Besar">Guru Besar</option>
                        @endrole
                        <option value="Guru KAFA">Guru KAFA</option>
                    </select>
                </div>

                @role('Super Admin')
                <div>
                    <label class="ek-label">Skop Sasaran <span class="text-red-500">*</span></label>
                    <select name="target_scope" id="target_scope" required
                            class="ek-input">
                        <option value="all">Semua Sekolah</option>
                        <option value="school">Sekolah Tertentu</option>
                    </select>
                </div>

                <div class="md:col-span-2 hidden" id="school_selection">
                    <label class="ek-label">Pilih Sekolah</label>
                    <select name="school_ids[]" multiple
                            class="ek-input">
                        @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Tekan Ctrl untuk pilih lebih dari satu</p>
                </div>
                @else
                <input type="hidden" name="target_scope" value="school">
                @endrole

                <div class="md:col-span-2">
                    <label class="ek-label">Isi Kandungan <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="10" placeholder="Tuliskan maklumat hebahan di sini..." required
                              class="ek-input">{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Terbitkan Hebahan
                </button>
                <a href="{{ route('announcements.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetScope     = document.getElementById('target_scope');
    const schoolSelection = document.getElementById('school_selection');
    if (!targetScope) return;

    targetScope.addEventListener('change', function() {
        schoolSelection.classList.toggle('hidden', this.value !== 'school');
    });
});
</script>
@endsection
