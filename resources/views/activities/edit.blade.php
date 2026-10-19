@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Edit Aktiviti: {{ $activity->name }}</h1>
        <a href="{{ route('activities.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form action="{{ route('activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="ek-label">Nama Aktiviti / Program <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $activity->name }}" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Peringkat Aktiviti <span class="text-red-500">*</span></label>
                    <select name="tahap" required
                            class="ek-input">
                        @foreach($tahapOptions as $value => $label)
                        <option value="{{ $value }}" {{ $activity->tahap == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Tarikh Aktiviti <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ $activity->date }}" required
                           class="ek-input">
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Deskripsi Ringkas</label>
                    <textarea name="description" rows="3"
                              class="ek-input">{{ $activity->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label" for="photo_edit">Tukar Gambar Dokumentasi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    @if($activity->photo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $activity->photo_path) }}" alt="Foto Semasa" class="h-24 rounded-lg border border-gray-200">
                    </div>
                    @endif
                    <div style="display:flex;align-items:center;border:1px solid #d1d5db;border-radius:0.5rem;overflow:hidden;background:#f9fafb;cursor:pointer;" onclick="document.getElementById('photo_edit').click()">
                        <span style="padding:0.5rem 1rem;background:#f3f4f6;border-right:1px solid #d1d5db;font-size:0.875rem;font-weight:500;color:#374151;white-space:nowrap;flex-shrink:0;">Pilih Fail</span>
                        <span id="photo_edit-fname" style="padding:0.5rem 0.75rem;font-size:0.875rem;color:#6b7280;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Tiada fail dipilih</span>
                    </div>
                    <input type="file" name="photo" id="photo_edit" accept="image/*" style="display:none;" onchange="updateFilename(this,'photo_edit-fname')">
                    <p style="margin-top:4px;font-size:0.75rem;color:#6b7280;" id="photo_edit_help">JPG, PNG atau JPEG (MAX. 2MB). Kosongkan jika tiada perubahan.</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Kemaskini Aktiviti
                </button>
                <a href="{{ route('activities.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
