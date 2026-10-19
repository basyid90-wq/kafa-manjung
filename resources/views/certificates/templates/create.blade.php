@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Tambah Templat Sijil</h1>
        <a href="{{ route('certificates.templates.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form method="POST" action="{{ route('certificates.templates.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div class="md:col-span-2">
                    <label class="ek-label">Nama Templat <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="cth: Sijil Penyertaan Sukaneka 2025"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                @role('Super Admin')
                <div id="wrapSchool">
                    <label class="ek-label">Sekolah</label>
                    <select name="school_id"
                            class="ek-input">
                        <option value="">Templat Platform (semua sekolah)</option>
                        @foreach($schools as $s)
                        <option value="{{ $s->id }}" {{ old('school_id')==$s->id ? 'selected':'' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <div>
                    <label class="ek-label">Susun Atur Teks <span class="text-red-500">*</span></label>
                    <select name="layout_style"
                            class="ek-input">
                        @foreach(['center'=>'Tengah','bottom'=>'Bawah','left'=>'Kiri','right'=>'Kanan'] as $val => $label)
                        <option value="{{ $val }}" {{ old('layout_style','center')===$val ? 'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="include_signature" id="chkSig" value="1"
                               {{ old('include_signature') ? 'checked':'' }}
                               class="w-4 h-4 rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Sertakan Tandatangan</span>
                    </label>
                </div>

                <div id="wrapSig" class="{{ old('include_signature') ? '' : 'hidden' }}">
                    <label class="ek-label" for="signature">Imej Tandatangan (PNG)</label>
                    <div style="display:flex;align-items:center;border:1px solid {{ $errors->has('signature') ? '#ef4444' : '#d1d5db' }};border-radius:0.5rem;overflow:hidden;background:#f9fafb;cursor:pointer;" onclick="document.getElementById('signature').click()">
                        <span style="padding:0.5rem 1rem;background:#f3f4f6;border-right:1px solid #d1d5db;font-size:0.875rem;font-weight:500;color:#374151;white-space:nowrap;flex-shrink:0;">Pilih Fail</span>
                        <span id="signature-fname" style="padding:0.5rem 0.75rem;font-size:0.875rem;color:#6b7280;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Tiada fail dipilih</span>
                    </div>
                    <input type="file" name="signature" id="signature" accept=".png,.jpg,.jpeg" style="display:none;" onchange="updateFilename(this,'signature-fname')">
                    <p style="margin-top:4px;font-size:0.75rem;color:#6b7280;" id="signature_help">PNG, JPG atau JPEG. Latar telus (PNG) lebih baik.</p>
                    @error('signature')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="ek-label" for="background">Imej Latar Belakang (JPEG/PNG, maks 5MB)</label>
                    <div style="display:flex;align-items:center;border:1px solid {{ $errors->has('background') ? '#ef4444' : '#d1d5db' }};border-radius:0.5rem;overflow:hidden;background:#f9fafb;cursor:pointer;" onclick="document.getElementById('background').click()">
                        <span style="padding:0.5rem 1rem;background:#f3f4f6;border-right:1px solid #d1d5db;font-size:0.875rem;font-weight:500;color:#374151;white-space:nowrap;flex-shrink:0;">Pilih Fail</span>
                        <span id="background-fname" style="padding:0.5rem 0.75rem;font-size:0.875rem;color:#6b7280;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Tiada fail dipilih</span>
                    </div>
                    <input type="file" name="background" id="background" accept=".jpg,.jpeg,.png" style="display:none;" onchange="updateFilename(this,'background-fname')">
                    <p style="margin-top:4px;font-size:0.75rem;color:#6b7280;" id="background_help">JPG, JPEG atau PNG (MAX. 5MB). Dimensi optimum: 2480 × 1754 px (A4 Landskap).</p>
                    @error('background')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Simpan Templat
                </button>
                <a href="{{ route('certificates.templates.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('chkSig').addEventListener('change', function() {
    document.getElementById('wrapSig').classList.toggle('hidden', !this.checked);
});
</script>
@endsection
