@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Aktiviti: {{ $activity->name }}</h1>
        <a href="{{ route('activities.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form action="{{ route('activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Aktiviti / Program <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $activity->name }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Peringkat Aktiviti <span class="text-red-500">*</span></label>
                    <select name="tahap" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach($tahapOptions as $value => $label)
                        <option value="{{ $value }}" {{ $activity->tahap == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarikh Aktiviti <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ $activity->date }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Ringkas</label>
                    <textarea name="description" rows="3"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ $activity->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="photo_edit">Tukar Gambar Dokumentasi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    @if($activity->photo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $activity->photo_path) }}" alt="Foto Semasa" class="h-24 rounded-lg border border-gray-200 dark:border-gray-700">
                    </div>
                    @endif
                    <input type="file" name="photo" id="photo_edit" accept="image/*"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                           aria-describedby="photo_edit_help">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="photo_edit_help">JPG, PNG atau JPEG (MAX. 2MB). Kosongkan jika tiada perubahan.</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Kemaskini Aktiviti
                </button>
                <a href="{{ route('activities.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
