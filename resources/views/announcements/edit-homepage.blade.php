@extends('layout.layout')

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container text-start">
        <div class="row mt--0">
            @include('partials.sidebar')
            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Edit Hebahan Homepage</h4>
                            <p class="text-muted small">Kemaskini hebahan yang dipaparkan di halaman login</p>
                        </div>

                        <form action="{{ route('announcements.update-homepage', $announcement) }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            @method('PUT')

                            <div class="col-lg-8 col-12">
                                <div class="rbt-form-group">
                                    <label for="title">Tajuk Hebahan</label>
                                    <input type="text" name="title" id="title" placeholder="Contoh: Modul Sijil Digital Kini Tersedia" value="{{ old('title', $announcement->title) }}" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="rbt-form-group">
                                    <label for="homepage_label">Label</label>
                                    <select name="homepage_label" id="homepage_label" class="rbt-big-select" required>
                                        <option value="Ciri Baharu" {{ old('homepage_label', $announcement->homepage_label) == 'Ciri Baharu' ? 'selected' : '' }}>🆕 Ciri Baharu</option>
                                        <option value="Pembaikan" {{ old('homepage_label', $announcement->homepage_label) == 'Pembaikan' ? 'selected' : '' }}>🔧 Pembaikan</option>
                                        <option value="Penyelenggaraan" {{ old('homepage_label', $announcement->homepage_label) == 'Penyelenggaraan' ? 'selected' : '' }}>⚠️ Penyelenggaraan</option>
                                        <option value="Kritikal" {{ old('homepage_label', $announcement->homepage_label) == 'Kritikal' ? 'selected' : '' }}>🚨 Kritikal</option>
                                        <option value="Pengumuman" {{ old('homepage_label', $announcement->homepage_label) == 'Pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="content_field">Isi Kandungan</label>
                                    <div id="content_field" style="height: 300px; background: white;"></div>
                                    <input type="hidden" name="content" id="content_hidden" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="expires_at">Tarikh Luput</label>
                                    <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at', $announcement->expires_at ? $announcement->expires_at->format('Y-m-d\TH:i') : '') }}" required>
                                    <small class="text-muted">Hebahan akan auto-hide selepas tarikh ini</small>
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="alert alert-info">
                                    <i class="feather-info"></i>
                                    <strong>Nota:</strong> Hebahan homepage hanya akan dipaparkan di halaman login dan tidak menghantar notifikasi kepada pengguna.
                                </div>
                            </div>

                            <div class="col-12 mt--20">
                                <div class="rbt-button-group justify-content-start">
                                    <button type="submit" class="rbt-btn btn-gradient">Kemaskini Hebahan</button>
                                    <a href="{{ route('announcements.index') }}" class="rbt-btn btn-border btn-sm">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quill Editor CSS -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

<!-- Quill Editor JS -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill Editor
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

    // Load existing content
    const existingContent = `{!! old('content', $announcement->content) !!}`;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Sync Quill content to hidden input on every change
    const hiddenInput = document.getElementById('content_hidden');
    hiddenInput.value = quill.root.innerHTML;

    quill.on('text-change', function() {
        hiddenInput.value = quill.root.innerHTML;
    });

    // Set minimum datetime to now
    const expiresAt = document.getElementById('expires_at');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    expiresAt.min = now.toISOString().slice(0, 16);
});
</script>
@endsection
