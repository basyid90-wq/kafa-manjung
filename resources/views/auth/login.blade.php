@section('title', 'Homepage')
@extends('layout.layout')

@php
    $bodyClass = '';
    $footer = 'true';
@endphp

@section('content')
<div class="rbt-elements-area bg-color-white pt--20 pb--50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center mb--50">
                    <h2 class="title" style="font-size: 48px; color: #2d3748; font-weight: 700;">Selamat Datang ke APKM</h2>
                    <p class="description" style="font-size: 1.5rem; color: #718096; font-weight: 500;">Aplikasi Pengurusan KAFA Daerah Manjung</p>
                </div>
            </div>
        </div>
        <div class="row gy-5 row--30">
            <!-- Bahagian Kiri: Log Masuk -->
            <div class="col-lg-5 col-md-12 col-12 order-2 order-lg-1">
                <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                    <div class="text-center mb--30">
                        <img src="{{ asset('template/perak.png') }}" alt="Logo Perak" style="max-height: 120px;">
                        <h4 class="title mt--20">Log Masuk Sistem</h4>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <ul class="nav nav-pills nav-justified mb-4" id="loginTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-staff" data-bs-toggle="pill" type="button" role="tab" aria-selected="true" style="font-size: 16px; font-weight: 600; border-radius: 50px;">
                                🏢 Kakitangan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-parent" data-bs-toggle="pill" type="button" role="tab" aria-selected="false" style="font-size: 16px; font-weight: 600; border-radius: 50px;">
                                👨‍👩‍👧‍👦 Ibu Bapa
                            </button>
                        </li>
                    </ul>

                    <form method="POST" action="{{ route('login') }}" class="max-width-auto">
                        @csrf
                        <input type="hidden" name="login_type" id="login_type" value="{{ old('login_type', 'staff') }}">
                        
                        <div class="form-group">
                            <input id="login_id" name="login_id" type="email" value="{{ old('login_id') }}" required autofocus placeholder=" ">
                            <label id="login_label">Alamat Emel</label>
                            <span class="focus-border"></span>
                            <x-input-error :messages="$errors->get('login_id')" class="mt-2 text-danger" />
                        </div>
                        <div class="form-group" style="position: relative;">
                            <input id="password-field" name="password" type="password" required placeholder=" ">
                            <label>Kata Laluan</label>
                            <span class="focus-border"></span>
                            <span class="password-toggle" onclick="togglePassword()">
                                <i id="toggle-icon" class="feather-eye"></i>
                            </span>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                        </div>

                        <div class="row mb--30 align-items-center">
                            <div class="col-lg-6 col-md-6 col-6">
                                <div class="rbt-checkbox">
                                    <input type="checkbox" id="remember_me" name="remember">
                                    <label for="remember_me">Ingat Saya</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6">
                                <div class="rbt-lost-password text-end">
                                    @if (Route::has('password.request'))
                                        <a class="rbt-btn-link" href="{{ route('password.request') }}">Lupa Kata Laluan?</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-submit-group">
                            <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Masuk Sekarang</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bahagian Kanan: Papan Makluman Utama -->
            <div class="col-lg-7 col-md-12 col-12 order-1 order-lg-2">
                <div class="rbt-shadow-box bg-color-white p-5 border-radius-10 h-100">
                    <div class="section-title mb--30">
                        <span class="subtitle bg-primary-opacity">Info Terkini</span>
                        <h4 class="title mt--10">Papan Makluman Utama</h4>
                    </div>

                    <div class="rbt-announcement-list">
                        @forelse($announcements as $announcement)
                            <div class="rbt-card variation-01 rbt-hover mb--20 border-bottom pb--20" style="border: none !important; border-bottom: 1px solid #eee !important; border-radius: 0;">
                                <div class="rbt-card-body p-0">
                                    <div class="rbt-category mb--10">
                                        @if($announcement->homepage_label)
                                            @php
                                                $labelColors = [
                                                    'Ciri Baharu' => 'bg-success',
                                                    'Pembaikan' => 'bg-info',
                                                    'Penyelenggaraan' => 'bg-warning',
                                                    'Kritikal' => 'bg-danger',
                                                    'Pengumuman' => 'bg-primary'
                                                ];
                                                $labelIcons = [
                                                    'Ciri Baharu' => '🆕',
                                                    'Pembaikan' => '🔧',
                                                    'Penyelenggaraan' => '⚠️',
                                                    'Kritikal' => '🚨',
                                                    'Pengumuman' => '📢'
                                                ];
                                                $colorClass = $labelColors[$announcement->homepage_label] ?? 'bg-secondary';
                                                $icon = $labelIcons[$announcement->homepage_label] ?? '';
                                            @endphp
                                            <span class="rbt-badge-card px-3 py-1 {{ $colorClass }}" style="font-size: 12px; font-weight: 600; color: white;">
                                                {{ $icon }} {{ $announcement->homepage_label }}
                                            </span>
                                        @else
                                            <span class="rbt-badge-card px-3 py-1 bg-secondary-opacity color-secondary" style="font-size: 12px; font-weight: 600;">
                                                Hebahan Umum
                                            </span>
                                        @endif
                                        <span class="ms-3 text-muted" style="font-size: 13px;">
                                            <i class="feather-calendar me-1"></i> {{ $announcement->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <h5 class="rbt-card-title mb--10">
                                        <a href="javascript:void(0);" onclick="showAnnouncementModal({{ $announcement->id }})" style="cursor: pointer;">{{ $announcement->title }}</a>
                                    </h5>
                                    <p class="description" style="font-size: 14px; line-height: 1.6; color: #666;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 120) }}
                                    </p>
                                    @if(strlen(strip_tags($announcement->content)) > 120)
                                    <a href="javascript:void(0);" onclick="showAnnouncementModal({{ $announcement->id }})" class="rbt-btn-link">Baca Selanjutnya <i class="feather-arrow-right"></i></a>
                                    @endif

                                    <!-- Hidden data for modal -->
                                    <div id="announcement-data-{{ $announcement->id }}" style="display: none;"
                                         data-title="{{ $announcement->title }}"
                                         data-author="{{ $announcement->user->name }}"
                                         data-is-admin="{{ $announcement->user->hasRole('Super Admin') ? '1' : '0' }}"
                                         data-date="{{ $announcement->created_at->format('d/m/Y') }}"
                                         data-label="{{ $announcement->homepage_label }}">
                                        {!! nl2br(e($announcement->content)) !!}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="rbt-round-icon bg-primary-opacity mx-auto mb--20" style="width: 80px; height: 80px; line-height: 80px; font-size: 30px;">
                                    <i class="feather-bell"></i>
                                </div>
                                <h5>Tiada Hebahan Baharu</h5>
                                <p>Sila semak semula kemudian untuk maklumat terkini.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($announcements->count() > 0)
                        <div class="view-all-btn mt--30 text-center">
                            <p class="text-muted small">* Sila log masuk untuk melihat butiran penuh hebahan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Baca Penuh Hebahan -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 2px solid #f0f0f0; padding: 25px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px 16px 0 0;">
                <div class="w-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span id="announcementModalLabel" class="badge px-3 py-2" style="font-size: 13px; font-weight: 600; background: rgba(255,255,255,0.25); color: white; border-radius: 8px;">
                            📢 Pengumuman
                        </span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <h4 class="modal-title text-white mb-2" id="announcementModalTitle" style="font-weight: 700; font-size: 24px; line-height: 1.3;"></h4>
                    <div class="d-flex align-items-center gap-2">
                        <span id="announcementModalAuthor" class="text-white" style="font-size: 14px; opacity: 0.95;">
                            <i class="feather-user" style="font-size: 13px;"></i> <span id="authorName"></span>
                        </span>
                        <span id="adminBadge" style="display: none;">
                            <span class="badge d-inline-flex align-items-center gap-1 px-2 py-1" style="background: rgba(255,255,255,0.3); color: white; font-size: 11px; font-weight: 600; border-radius: 6px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                Pentadbir Sistem
                            </span>
                        </span>
                        <span class="text-white" style="font-size: 13px; opacity: 0.9;">
                            <i class="feather-calendar" style="font-size: 12px;"></i> <span id="announcementDate"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="padding: 35px 30px; background: #fafbfc;">
                <div id="announcementModalBody" style="white-space: pre-line; line-height: 1.9; font-size: 15px; color: #2d3748; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);"></div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e8e8e8; padding: 20px 30px; background: #fafbfc; border-radius: 0 0 16px 16px;">
                <button type="button" class="rbt-btn btn-gradient btn-sm" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 8px;">
                    <i class="feather-check"></i> Faham
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-opacity { background: rgba(110, 65, 255, 0.1); color: #6e41ff; }
    .bg-secondary-opacity { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .subtitle {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .rbt-contact-form.contact-form-style-1 .form-group input:placeholder-shown + label {
        top: 25px;
        font-size: 16px;
    }
    .rbt-contact-form.contact-form-style-1 .form-group input:focus + label,
    .rbt-contact-form.contact-form-style-1 .form-group input:not(:placeholder-shown) + label {
        top: 5px;
        font-size: 12px;
        color: var(--color-primary);
    }
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #718096;
        z-index: 10;
        transition: 0.3s;
        padding: 5px;
    }
    .password-toggle:hover {
        color: var(--color-primary);
    }
</style>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password-field');
        const toggleIcon = document.getElementById('toggle-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('feather-eye');
            toggleIcon.classList.add('feather-eye-off');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('feather-eye-off');
            toggleIcon.classList.add('feather-eye');
        }
    }

    function showAnnouncementModal(announcementId) {
        const dataDiv = document.getElementById('announcement-data-' + announcementId);

        // Extract data attributes
        const title = dataDiv.getAttribute('data-title');
        const author = dataDiv.getAttribute('data-author');
        const isAdmin = dataDiv.getAttribute('data-is-admin') === '1';
        const date = dataDiv.getAttribute('data-date');
        const label = dataDiv.getAttribute('data-label');
        const content = dataDiv.innerHTML;

        // Set modal content
        document.getElementById('announcementModalTitle').textContent = title;
        document.getElementById('announcementModalBody').innerHTML = content;
        document.getElementById('authorName').textContent = author;
        document.getElementById('announcementDate').textContent = date;

        // Set label badge
        const labelBadge = document.getElementById('announcementModalLabel');
        const labelIcons = {
            'Ciri Baharu': '🆕',
            'Pembaikan': '🔧',
            'Penyelenggaraan': '⚠️',
            'Kritikal': '🚨',
            'Pengumuman': '📢'
        };
        labelBadge.textContent = (labelIcons[label] || '📢') + ' ' + label;

        // Show admin badge if author is Super Admin
        const adminBadge = document.getElementById('adminBadge');
        if (isAdmin) {
            adminBadge.style.display = 'inline-block';
        } else {
            adminBadge.style.display = 'none';
        }

        const modal = new bootstrap.Modal(document.getElementById('announcementModal'));
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tabStaff = document.getElementById('tab-staff');
        const tabParent = document.getElementById('tab-parent');
        const loginType = document.getElementById('login_type');
        const loginId = document.getElementById('login_id');
        const loginLabel = document.getElementById('login_label');

        tabStaff.addEventListener('click', function() {
            loginType.value = 'staff';
            loginLabel.textContent = 'Alamat Emel';
            loginId.type = 'email';
        });

        tabParent.addEventListener('click', function() {
            loginType.value = 'parent';
            loginLabel.textContent = 'No. Kad Pengenalan Ibu/Bapa';
            loginId.type = 'text';
        });

        // Initialize state based on validation old() input
        if (loginType.value === 'parent') {
            tabStaff.classList.remove('active');
            tabStaff.setAttribute('aria-selected', 'false');
            tabParent.classList.add('active');
            tabParent.setAttribute('aria-selected', 'true');
            
            loginLabel.textContent = 'No. Kad Pengenalan Ibu/Bapa';
            loginId.type = 'text';
        }
    });
</script>
@endsection
