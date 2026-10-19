@extends('layout-fb.layout')

@section('content')
<div>

    <div class="mb-6">
        <h1 class="ek-page-title">Edit Hebahan Homepage</h1>
        <p class="ek-page-sub mt-1">Kemaskini hebahan yang dipaparkan di halaman login.</p>
    </div>

    <div class="ek-card">
        <form action="{{ route('announcements.update-homepage', $announcement) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">

                <div class="md:col-span-3">
                    <label class="ek-label">Tajuk Hebahan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" placeholder="Contoh: Modul Sijil Digital Kini Tersedia"
                           value="{{ old('title', $announcement->title) }}" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Label <span class="text-red-500">*</span></label>
                    <select name="homepage_label" required
                            class="ek-input">
                        <option value="Ciri Baharu" {{ old('homepage_label', $announcement->homepage_label) == 'Ciri Baharu' ? 'selected' : '' }}>🆕 Ciri Baharu</option>
                        <option value="Pembaikan" {{ old('homepage_label', $announcement->homepage_label) == 'Pembaikan' ? 'selected' : '' }}>🔧 Pembaikan</option>
                        <option value="Penyelenggaraan" {{ old('homepage_label', $announcement->homepage_label) == 'Penyelenggaraan' ? 'selected' : '' }}>⚠️ Penyelenggaraan</option>
                        <option value="Kritikal" {{ old('homepage_label', $announcement->homepage_label) == 'Kritikal' ? 'selected' : '' }}>🚨 Kritikal</option>
                        <option value="Pengumuman" {{ old('homepage_label', $announcement->homepage_label) == 'Pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="ek-label">Isi Kandungan <span class="text-red-500">*</span></label>
                    <div id="content_field" class="bg-white" style="height:300px;"></div>
                    <input type="hidden" name="content" id="content_hidden" required>
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Tarikh Luput <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="expires_at" id="expires_at"
                           value="{{ old('expires_at', $announcement->expires_at ? $announcement->expires_at->format('Y-m-d\TH:i') : '') }}" required
                           class="ek-input">
                    <p class="text-xs text-gray-400 mt-1">Hebahan akan auto-hide selepas tarikh ini.</p>
                </div>

                <div class="md:col-span-4">
                    <div class="flex items-start gap-2 bg-blue-50 border border-blue-200 rounded-lg px-4 py-3 text-sm text-blue-700">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span><strong>Nota:</strong> Hebahan homepage hanya akan dipaparkan di halaman login dan tidak menghantar notifikasi kepada pengguna.</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Kemaskini Hebahan
                </button>
                <a href="{{ route('announcements.index') }}"
                   class="ek-btn-secondary">
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

    const existingContent = `{!! old('content', $announcement->content) !!}`;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    const hiddenInput = document.getElementById('content_hidden');
    hiddenInput.value = quill.root.innerHTML;
    quill.on('text-change', function() {
        hiddenInput.value = quill.root.innerHTML;
    });

    const expiresAt = document.getElementById('expires_at');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    expiresAt.min = now.toISOString().slice(0, 16);
});
</script>
@endsection
