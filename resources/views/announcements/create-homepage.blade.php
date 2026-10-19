@extends('layout-fb.layout')

@section('content')
<div>

    <div class="mb-6">
        <h1 class="ek-page-title">Cipta Hebahan Homepage</h1>
        <p class="ek-page-sub mt-1">Hebahan ini akan dipaparkan di halaman login untuk maklumkan update sistem.</p>
    </div>

    <div class="ek-card">
        <form action="{{ route('announcements.store-homepage') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">

                <div class="md:col-span-3">
                    <label class="ek-label">Tajuk Hebahan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" placeholder="Contoh: Modul Sijil Digital Kini Tersedia"
                           value="{{ old('title') }}" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Label <span class="text-red-500">*</span></label>
                    <select name="homepage_label" required
                            class="ek-input">
                        <option value="Ciri Baharu">🆕 Ciri Baharu</option>
                        <option value="Pembaikan">🔧 Pembaikan</option>
                        <option value="Penyelenggaraan">⚠️ Penyelenggaraan</option>
                        <option value="Kritikal">🚨 Kritikal</option>
                        <option value="Pengumuman">📢 Pengumuman</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="ek-label">Isi Kandungan <span class="text-red-500">*</span></label>
                    <div id="content_field" class="bg-white" style="height:300px;"></div>
                    <input type="hidden" name="content" id="content_hidden" required>
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Tarikh Luput <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" required
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
                    Terbitkan Hebahan Homepage
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
