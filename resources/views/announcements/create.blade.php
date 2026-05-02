@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Cipta Hebahan Baru</h1>
        </div>
        <a href="{{ route('announcements.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form action="{{ route('announcements.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tajuk Hebahan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Tajuk pengumuman..." required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                    <select name="category"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach(['Mesyuarat','Taklimat','Kursus','Pekeliling','Lain-lain'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sasaran Role <span class="text-red-500">*</span></label>
                    <select name="target_role" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @role('Super Admin')
                        <option value="Semua">Semua Pengguna</option>
                        <option value="Pentadbir">Pentadbir</option>
                        <option value="Penyelia KAFA">Penyelia KAFA</option>
                        <option value="Guru Besar">Guru Besar</option>
                        <option value="Guru KAFA">Guru KAFA</option>
                        <option value="Pembekal">Pembekal</option>
                        @endrole
                        @role('Pentadbir')
                        <option value="Penyelia KAFA">Penyelia KAFA</option>
                        <option value="Guru Besar">Guru Besar</option>
                        <option value="Guru KAFA">Guru KAFA</option>
                        <option value="Pembekal">Pembekal</option>
                        @endrole
                        @role('Penyelia KAFA')
                        <option value="Guru Besar">Guru Besar</option>
                        <option value="Guru KAFA">Guru KAFA</option>
                        <option value="Pembekal">Pembekal</option>
                        @endrole
                        @role('Guru Besar')
                        <option value="Guru KAFA">Guru KAFA</option>
                        @endrole
                        @role('Pembekal')
                        <option value="Penyelia KAFA">Penyelia KAFA</option>
                        <option value="Guru Besar">Guru Besar</option>
                        <option value="Guru KAFA">Guru KAFA</option>
                        @endrole
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Skop Sasaran <span class="text-red-500">*</span></label>
                    <select name="target_scope" id="target_scope" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="all">Semua</option>
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA']))
                        <option value="district">Daerah Tertentu</option>
                        @endif
                        <option value="school">Sekolah Tertentu</option>
                    </select>
                </div>

                @if(auth()->user()->hasAnyRole(['Super Admin', 'Pentadbir']))
                <div class="md:col-span-2 hidden" id="district_selection">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Daerah</label>
                    <select name="district_ids[]" multiple
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Tekan Ctrl untuk pilih lebih dari satu</p>
                </div>
                @endif

                <div class="md:col-span-2 hidden" id="school_selection">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Sekolah</label>
                    <select name="school_ids[]" multiple
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }} @if($school->district)({{ $school->district->name }})@endif</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Tekan Ctrl untuk pilih lebih dari satu</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Kandungan <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="10" placeholder="Tuliskan maklumat hebahan di sini..." required
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Terbitkan Hebahan
                </button>
                <a href="{{ route('announcements.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetScope     = document.getElementById('target_scope');
    const districtSelection = document.getElementById('district_selection');
    const schoolSelection   = document.getElementById('school_selection');

    targetScope.addEventListener('change', function() {
        if (this.value === 'district') {
            if (districtSelection) districtSelection.classList.remove('hidden');
            schoolSelection.classList.add('hidden');
        } else if (this.value === 'school') {
            if (districtSelection) districtSelection.classList.add('hidden');
            schoolSelection.classList.remove('hidden');
        } else {
            if (districtSelection) districtSelection.classList.add('hidden');
            schoolSelection.classList.add('hidden');
        }
    });
});
</script>
@endsection
