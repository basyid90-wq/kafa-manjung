@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Templat Sijil</h1>
        <a href="{{ route('certificates.templates.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form method="POST" action="{{ route('certificates.templates.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Templat <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="cth: Sijil Penyertaan Sukaneka 2025"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                @hasanyrole('Super Admin|Pentadbir|Penyelia KAFA')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Peringkat <span class="text-red-500">*</span></label>
                    <select name="level" id="selectLevel"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="sekolah" {{ old('level','sekolah')==='sekolah' ? 'selected':'' }}>Sekolah</option>
                        <option value="daerah"  {{ old('level')==='daerah'  ? 'selected':'' }}>Daerah</option>
                    </select>
                </div>
                @endhasanyrole

                @if($districts->isNotEmpty())
                <div id="wrapDistrict">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Daerah</label>
                    <select name="district_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Daerah --</option>
                        @foreach($districts as $d)
                        <option value="{{ $d->id }}" {{ old('district_id')==$d->id ? 'selected':'' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if($schools->isNotEmpty())
                <div id="wrapSchool">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sekolah</label>
                    <select name="school_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schools as $s)
                        <option value="{{ $s->id }}" {{ old('school_id')==$s->id ? 'selected':'' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Susun Atur Teks <span class="text-red-500">*</span></label>
                    <select name="layout_style"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
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
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sertakan Tandatangan</span>
                    </label>
                </div>

                <div id="wrapSig" class="{{ old('include_signature') ? '' : 'hidden' }}">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="signature">Imej Tandatangan (PNG)</label>
                    <input type="file" name="signature" id="signature" accept=".png,.jpg,.jpeg"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('signature') border-red-500 @enderror"
                           aria-describedby="signature_help">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="signature_help">PNG, JPG atau JPEG. Latar telus (PNG) lebih baik.</p>
                    @error('signature')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="background">Imej Latar Belakang (JPEG/PNG, maks 5MB)</label>
                    <input type="file" name="background" id="background" accept=".jpg,.jpeg,.png"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('background') border-red-500 @enderror"
                           aria-describedby="background_help">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="background_help">JPG, JPEG atau PNG (MAX. 5MB). Dimensi optimum: 2480 × 1754 px (A4 Landskap).</p>
                    @error('background')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Simpan Templat
                </button>
                <a href="{{ route('certificates.templates.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
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
document.addEventListener('DOMContentLoaded', function () {
    var sel = document.getElementById('selectLevel');
    var wrapSchool = document.getElementById('wrapSchool');
    if (sel && wrapSchool) {
        function toggleSchool() {
            wrapSchool.classList.toggle('hidden', sel.value !== 'sekolah');
        }
        sel.addEventListener('change', toggleSchool);
        toggleSchool();
    }
});
</script>
@endsection
