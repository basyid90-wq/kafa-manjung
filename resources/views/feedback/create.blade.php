@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Laporkan Masalah</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Aduan anda akan disemak oleh pentadbir sistem.</p>
        </div>
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-4 py-3 mb-4 text-sm text-green-700 dark:text-green-400">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4 mb-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modul Bermasalah <span class="text-red-500">*</span></label>
                    <select name="module" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Modul --</option>
                        @foreach($modules as $m)
                            <option value="{{ $m }}" {{ old('module') === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Penerangan Masalah <span class="text-red-500">*</span></label>
                    <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center justify-between px-3 py-2 border-b dark:border-gray-600">
                            <div class="flex flex-wrap items-center divide-gray-200 dark:divide-gray-600 sm:divide-x sm:rtl:divide-x-reverse">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                    <button type="button" onclick="formatDoc('bold')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h4.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0-7H6m2 7h6.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0 0H6"/>
                                        </svg>
                                        <span class="sr-only">Bold</span>
                                    </button>
                                    <button type="button" onclick="formatDoc('italic')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.874 19 6.143-14M6 19h6.33m-.66-14H18"/>
                                        </svg>
                                        <span class="sr-only">Italic</span>
                                    </button>
                                    <button type="button" onclick="formatDoc('underline')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 19h12M8 5v9a4 4 0 0 0 8 0V5M6 5h4m4 0h4"/>
                                        </svg>
                                        <span class="sr-only">Underline</span>
                                    </button>
                                </div>
                                <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                                    <button type="button" onclick="formatDoc('insertUnorderedList')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                                        </svg>
                                        <span class="sr-only">Bullet list</span>
                                    </button>
                                    <button type="button" onclick="formatDoc('insertOrderedList')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4"/>
                                        </svg>
                                        <span class="sr-only">Numbered list</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800">
                            <div id="wysiwyg" contenteditable="true" class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400 min-h-[120px] max-h-[300px] overflow-y-auto" style="outline: none;">{{ old('description') }}</div>
                        </div>
                    </div>
                    <textarea name="description" id="description" class="hidden" required></textarea>
                    <p class="text-xs text-gray-400 mt-1">Maksimum 2000 aksara.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tangkapan Skrin <span class="text-gray-400 font-normal">(Pilihan)</span></label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG, GIF, WEBP. Saiz maksimum: 4MB.</p>
                    <div id="imagePreview" class="hidden mt-2">
                        <img id="previewImg" src="#" alt="Preview"
                             class="max-w-xs max-h-48 rounded-lg border border-gray-200 dark:border-gray-700">
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Hantar Aduan
                </button>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// WYSIWYG Editor functions
function formatDoc(cmd, value = null) {
    document.execCommand(cmd, false, value);
    document.getElementById('wysiwyg').focus();
}

// Sync contenteditable to hidden textarea before submit
document.querySelector('form').addEventListener('submit', function(e) {
    const content = document.getElementById('wysiwyg').innerHTML;
    const plainText = document.getElementById('wysiwyg').innerText || document.getElementById('wysiwyg').textContent;

    if (plainText.trim().length === 0) {
        e.preventDefault();
        alert('Sila isi penerangan masalah.');
        return false;
    }

    if (plainText.length > 2000) {
        e.preventDefault();
        alert('Penerangan terlalu panjang. Maksimum 2000 aksara.');
        return false;
    }

    document.getElementById('description').value = content;
});

// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('previewImg').src = ev.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
