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
                            <h4 class="rbt-title-style-3">Cipta Hebahan Homepage</h4>
                            <p class="text-muted small">Hebahan ini akan dipaparkan di halaman login untuk maklumkan update sistem</p>
                        </div>

                        <form action="{{ route('announcements.store-homepage') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf

                            <div class="col-lg-8 col-12">
                                <div class="rbt-form-group">
                                    <label for="title">Tajuk Hebahan</label>
                                    <input type="text" name="title" id="title" placeholder="Contoh: Modul Sijil Digital Kini Tersedia" value="{{ old('title') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="rbt-form-group">
                                    <label for="homepage_label">Label</label>
                                    <select name="homepage_label" id="homepage_label" class="rbt-big-select" required>
                                        <option value="Ciri Baharu">🆕 Ciri Baharu</option>
                                        <option value="Pembaikan">🔧 Pembaikan</option>
                                        <option value="Penyelenggaraan">⚠️ Penyelenggaraan</option>
                                        <option value="Kritikal">🚨 Kritikal</option>
                                        <option value="Pengumuman">📢 Pengumuman</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="rbt-form-group">
                                    <label for="content_field">Isi Kandungan</label>
                                    <textarea name="content" id="content_field" rows="8" placeholder="Tuliskan maklumat update sistem di sini..." required>{{ old('content') }}</textarea>
                                    <small class="text-muted">Contoh: Sistem kini menyokong penjanaan sijil digital untuk murid. Sijil boleh dimuat turun dalam format PDF dengan tulisan Jawi.</small>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="rbt-form-group">
                                    <label for="expires_at">Tarikh Luput</label>
                                    <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" required>
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
                                    <button type="submit" class="rbt-btn btn-gradient">Terbitkan Hebahan Homepage</button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum datetime to now
    const expiresAt = document.getElementById('expires_at');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    expiresAt.min = now.toISOString().slice(0, 16);

    // Set default to 7 days from now
    const defaultExpiry = new Date();
    defaultExpiry.setDate(defaultExpiry.getDate() + 7);
    defaultExpiry.setMinutes(defaultExpiry.getMinutes() - defaultExpiry.getTimezoneOffset());
    if (!expiresAt.value) {
        expiresAt.value = defaultExpiry.toISOString().slice(0, 16);
    }
});
</script>
@endsection
