@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Cipta Hebahan Homepage</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Hebahan ini akan dipaparkan di halaman login untuk maklumkan update sistem.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form action="{{ route('announcements.store-homepage') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tajuk Hebahan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" placeholder="Contoh: Modul Sijil Digital Kini Tersedia"
                           value="{{ old('title') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Label <span class="text-red-500">*</span></label>
                    <select name="homepage_label" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="Ciri Baharu">🆕 Ciri Baharu</option>
                        <option value="Pembaikan">🔧 Pembaikan</option>
                        <option value="Penyelenggaraan">⚠️ Penyelenggaraan</option>
                        <option value="Kritikal">🚨 Kritikal</option>
                        <option value="Pengumuman">📢 Pengumuman</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Kandungan <span class="text-red-500">*</span></label>
                    <div id="content_field" class="bg-white" style="height:300px;"></div>
                    <input type="hidden" name="content" id="content_hidden" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarikh Luput <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Hebahan akan auto-hide selepas tarikh ini.</p>
                </div>

                <div class="md:col-span-4">
                    <div class="flex items-start gap-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg px-4 py-3 text-sm text-blue-700 dark:text-blue-400">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span><strong>Nota:</strong> Hebahan homepage hanya akan dipaparkan di halaman login dan tidak menghantar notifikasi kepada pengguna.</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Terbitkan Hebahan Homepage
                </button>
                <a href="{{ route('announcements.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quill = new Quill('#content_field', {
        theme: 'snow',
        placeholder: 'Tuliskan maklumat update sistem di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    const hiddenInput = document.getElementById('content_hidden');
    quill.on('text-change', function() {
        hiddenInput.value = quill.root.innerHTML;
    });

    const oldContent = `{{ old('content') }}`;
    if (oldContent) {
        quill.root.innerHTML = oldContent;
        hiddenInput.value = oldContent;
    }

    const expiresAt = document.getElementById('expires_at');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    expiresAt.min = now.toISOString().slice(0, 16);

    const defaultExpiry = new Date();
    defaultExpiry.setDate(defaultExpiry.getDate() + 7);
    defaultExpiry.setMinutes(defaultExpiry.getMinutes() - defaultExpiry.getTimezoneOffset());
    if (!expiresAt.value) {
        expiresAt.value = defaultExpiry.toISOString().slice(0, 16);
    }
});
</script>
@endsection
