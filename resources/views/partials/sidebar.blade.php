<div class="col-lg-3">
    <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
        <div class="inner">
            <div class="content-item-content">
                <div class="rbt-default-sidebar-wrapper">

                    @hasrole('Ibu Bapa')
                    {{-- ── Sidebar: Ibu Bapa / Penjaga ── --}}
                    <div class="section-title mb--20">
                        <h6 class="rbt-title-style-2">Portal Ibu Bapa</h6>
                    </div>
                    <nav class="mainmenu-nav">
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <li>
                                <a href="{{ route('parent.dashboard') }}"
                                   class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                                    <i class="feather-home"></i><span>Laman Utama</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('parent.results.index') }}"
                                   class="{{ request()->routeIs('parent.results.*') ? 'active' : '' }}">
                                    <i class="feather-bar-chart-2"></i><span>Keputusan Peperiksaan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('attendances.index') }}"
                                   class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                                    <i class="feather-calendar"></i><span>Rekod Kehadiran</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('disciplinary.index') }}"
                                   class="{{ request()->routeIs('disciplinary.*') ? 'active' : '' }}">
                                    <i class="feather-alert-triangle"></i><span>Rekod Disiplin</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    @else
                    {{-- ── Sidebar: Kakitangan ── --}}
                    <div class="section-title mb--20">
                        <h6 class="rbt-title-style-2">Menu Utama</h6>
                    </div>
                    <nav class="mainmenu-nav">
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="feather-home"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pengurusan.index') }}"
                                   class="{{ request()->routeIs('pengurusan.index') ? 'active' : '' }}">
                                    <i class="feather-grid"></i><span>Pengurusan Pentadbiran</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    @endhasrole

                    @role('Super Admin')
                    <div class="section-title mt--40 mb--20">
                        <h6 class="rbt-title-style-2">Pemantauan</h6>
                    </div>
                    <nav class="mainmenu-nav">
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <li>
                                <a href="{{ route('admin.manual.logs') }}"
                                   class="{{ request()->routeIs('admin.manual.logs') ? 'active' : '' }}">
                                    <i class="feather-book-open"></i><span>Log Panduan Pengguna</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('feedback.index') }}"
                                   class="{{ request()->routeIs('feedback.*') ? 'active' : '' }}">
                                    <i class="feather-message-circle"></i><span>Aduan Masalah</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.system_log') }}"
                                   class="{{ request()->routeIs('admin.system_log') ? 'active' : '' }}">
                                    <i class="feather-terminal"></i><span>Log Sistem</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    @endrole

                    @unless(auth()->user()->hasRole('Super Admin'))
                    <div class="section-title mt--40 mb--20">
                        <h6 class="rbt-title-style-2">Panduan</h6>
                    </div>
                    <nav class="mainmenu-nav">
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <li>
                                <a href="{{ route('feedback.create') }}"
                                   class="{{ request()->routeIs('feedback.create') ? 'active' : '' }}">
                                    <i class="feather-alert-circle"></i><span>Laporkan Masalah</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"
                                   onclick="openPdfBlob(this, '{{ route('manual.download') }}')">
                                    <i class="feather-book-open"></i><span>Panduan Pengguna</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    @endunless

                    <div class="section-title mt--40 mb--20">
                        <h6 class="rbt-title-style-2">Akaun</h6>
                    </div>
                    <nav class="mainmenu-nav">
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="feather-log-out"></i><span>Log Keluar</span>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>
