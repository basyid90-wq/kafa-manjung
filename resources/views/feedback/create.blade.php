@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Laporkan Masalah</h1>
            <p class="text-xs text-gray-500 mt-0.5">Aduan anda akan disemak oleh pentadbir sistem.</p>
        </div>
        <a href="{{ route('dashboard') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-4 text-sm text-green-700">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="ek-card">
        <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4 mb-5">

                <div>
                    <label class="ek-label">Modul Bermasalah <span class="text-red-500">*</span></label>
                    <select name="module" required
                            class="ek-input">
                        <option value="">-- Pilih Modul --</option>
                        @foreach($modules as $m)
                            <option value="{{ $m }}" {{ old('module') === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="ek-label">Penerangan Masalah <span class="text-red-500">*</span></label>
                    <div class="w-full border border-gray-200 rounded-lg bg-gray-50">
                        <div class="flex items-center justify-between px-3 py-2 border-b">
                            <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                    <button type="button" onclick="formatDoc('bold')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h4.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0-7H6m2 7h6.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0 0H6"/>
                                        </svg>
                                        <span class="sr-only">Bold</span>
                                    </button>
                                    <button type="button" onclick="formatDoc('italic')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.874 19 6.143-14M6 19h6.33m-.66-14H18"/>
                                        </svg>
                                        <span class="sr-only">Italic</span>
                                    </button>
                                    <button type="button" onclick="formatDoc('underline')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 19h12M8 5v9a4 4 0 0 0 8 0V5M6 5h4m4 0h4"/>
                                        </svg>
                                        <span class="sr-only">Underline</span>
                                    </button>
                                </div>
                                <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                                    <button type="button" onclick="formatDoc('insertUnorderedList')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                                        </svg>
                                        <span class="sr-only">Bullet list</span>
                                    </button>
                                    <button type="button" onclick="formatDoc('insertOrderedList')" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4"/>
                                        </svg>
                                        <span class="sr-only">Numbered list</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-white rounded-b-lg">
                            <div id="wysiwyg" contenteditable="true" class="block w-full px-0 text-sm text-gray-800 bg-white border-0 focus:ring-0 min-h-[120px] max-h-[300px] overflow-y-auto" style="outline: none;">{{ old('description') }}</div>
                        </div>
                    </div>
                    <textarea name="description" id="description" class="hidden" required></textarea>
                    <p class="text-xs text-gray-400 mt-1">Maksimum 2000 aksara.</p>
                </div>

                <div>
                    <label class="ek-label" for="image">Tangkapan Skrin <span class="text-gray-400 font-normal">(Pilihan)</span></label>
                    <div style="display:flex;align-items:center;border:1px solid #d1d5db;border-radius:0.5rem;overflow:hidden;background:#f9fafb;cursor:pointer;" onclick="document.getElementById('image').click()">
                        <span style="padding:0.5rem 1rem;background:#f3f4f6;border-right:1px solid #d1d5db;font-size:0.875rem;font-weight:500;color:#374151;white-space:nowrap;flex-shrink:0;">Pilih Fail</span>
                        <span id="image-fname" style="padding:0.5rem 0.75rem;font-size:0.875rem;color:#6b7280;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Tiada fail dipilih</span>
                    </div>
                    <input type="file" name="image" id="image" accept="image/*" style="display:none;" onchange="updateFilename(this,'image-fname')">
                    <p style="margin-top:4px;font-size:0.75rem;color:#6b7280;" id="image_help">JPG, PNG, GIF atau WEBP (MAX. 4MB).</p>
                    <div id="imagePreview" class="hidden mt-2">
                        <img id="previewImg" src="#" alt="Preview"
                             class="max-w-xs max-h-48 rounded-lg border border-gray-200">
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Hantar Aduan
                </button>
                <a href="{{ route('dashboard') }}"
                   class="ek-btn-secondary">
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
