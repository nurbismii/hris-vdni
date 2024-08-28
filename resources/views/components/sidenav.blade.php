<div id="layoutSidenav_nav">
    <nav class="sidenav sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                @if(strtolower(Auth::user()->job->permission_role ?? '') != 'administrator')
                <div class="sidenav-menu-heading d-sm-none">Pemberitahuan</div>
                <a class="nav-link d-sm-none" href="/lihat-pengingat">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Pengingat
                    @if(getCountPengingat() > 0)
                    <span class="badge bg-success-soft text-success ms-auto">{{ getCountPengingat() }} Baru!</span>
                    @endif
                </a>
                @endif
                <div class="sidenav-menu-heading">Info</div>
                <a class="nav-link {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}" href="/dashboard">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <a class="nav-link {{ (request()->segment(1) == 'audit-trails') ? 'active' : '' }}" href="/audit-trails">
                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                    Jejak Aktivitas
                </a>
                <div class="sidenav-menu-heading">Inti</div>
                <a class="nav-link {{ (request()->segment(1) == 'users') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Pengguna
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'users') ? 'show' : '' }}" id="collapseUsers" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('users', 'users')) ? 'active' : '' }}" href="/users">Data Pengguna</a>
                        <a class="nav-link {{ (request()->segment(2) == 'last-login') ? 'active' : '' }}" href="/users/last-login">Riwayat masuk</a>
                    </nav>
                </div>
                <a class="nav-link {{ (request()->segment(1) == 'employees' || request()->segment(1) == 'roles') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmployees" aria-expanded="false" aria-controls="collapseEmployees">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Karyawan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'employees' || request()->segment(1) == 'roles') ? 'show' : '' }}" id="collapseEmployees" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavemployee">
                        <a class="nav-link {{ (request()->is('employees', 'employees')) ? 'active' : '' }}" href="{{ url('employees')}}">Daftar karyawan</a>
                        <!-- <a class="nav-link {{ (request()->segment(1) == 'roles') ? 'active' : '' }}" href="/roles">Peran dan akses</a> -->
                        <a class="nav-link {{ (request()->segment(2) == 'import') ? 'active' : '' }}" href="/employees/import">Import karyawan</a>
                    </nav>
                </div>
                <a class="nav-link {{ (request()->segment(1) == 'perusahaan') ? 'active' : '' }}" href="/perusahaan">
                    <div class="nav-link-icon"><i data-feather="codepen"></i></div>
                    Perusahaan
                </a>
                @endif

                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator' || strtolower(Auth::user()->job->permission_role ?? '') == 'hubungan industrial')
                <a class="nav-link {{ (request()->segment(1) == 'industrial-relations') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCoreHr" aria-expanded="false" aria-controls="collapseCoreHr">
                    <div class="nav-link-icon"><i data-feather="link"></i></div>
                    Hubungan Industrial
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'industrial-relations') ? 'show' : '' }}" id="collapseCoreHr" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('contract', 'contract')) ? 'active' : '' }}" href="/contract">PKWT 1</a>
                        <a class="nav-link {{ (request()->segment(2) == 'severance-pay') ? 'active' : '' }}" href="/industrial-relations/severance-pay">Pesangon</a>
                        <a class="nav-link {{ (request()->segment(2) == 'sp-report') ? 'active' : '' }}" href="/industrial-relations/sp-report">Peringatan</a>
                        <a class="nav-link {{ (request()->segment(2) == 'resign') ? 'active' : '' }}" href="/industrial-relations/resign">Pengunduran Diri</a>
                    </nav>
                </div>
                @endif

                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <a class="nav-link {{ (request()->segment(1) == 'salary' && request()->segment(2) == 'employee') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePayroll" aria-expanded="false" aria-controls="collapsePayroll">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Penggajian
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'salary') ? 'show' : '' }}" id="collapsePayroll" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->segment(1) == 'salary') ? 'active' : '' }}" href="/salary/employee">Slip gaji</a>
                    </nav>
                </div>
                @endif

                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator' || strtolower(Auth::user()->job->permission_role ?? '') == 'keuntungan dan manfaat')
                <a class="nav-link {{ (request()->segment(1) == 'kompensasi-dan-keuntungan') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
                    <div class="nav-link-icon"><i data-feather="folder-plus"></i></div>
                    Kompensasi & Benefit
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'kompensasi-dan-keuntungan') ? 'show' : '' }}" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->segment(1) == 'kompensasi-dan-keuntungan' && request()->segment(2) == 'cuti-izin') ? 'active' : '' }}" href="/kompensasi-dan-keuntungan/cuti-izin">Kelola Cuti & Izin</a>
                        <a class="nav-link {{ (request()->segment(1) == 'kompensasi-dan-keuntungan' && request()->segment(2) == 'cuti-roster') ? 'active' : '' }}" href="/kompensasi-dan-keuntungan/cuti-roster">Kelola Cuti Roster</a>
                        <a class="nav-link {{ (request()->segment(1) == 'kompensasi-dan-keuntungan' && request()->segment(2) == 'lembur') ? 'active' : '' }}" href="/kompensasi-dan-keuntungan/lembur">Kelola Lembur</a>
                        <a class="nav-link {{ (request()->segment(1) == 'kompensasi-dan-keuntungan' && request()->segment(2) == 'pengingat') ? 'active' : '' }}" href="/kompensasi-dan-keuntungan/pengingat">Pengingat</a>
                        <a class="nav-link {{ (request()->segment(1) == 'kompensasi-dan-keuntungan' && request()->segment(2) == 'absen') ? 'active' : '' }}" href="/kompensasi-dan-keuntungan/absen">Absensi</a>
                    </nav>
                </div>
                @endif

                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <a class="nav-link {{ request()->segment(1) == 'wilayah' ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Laporan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->segment(1) == 'wilayah' ? 'show' : '' }}" id="collapseLaporan" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->segment(1) == 'wilayah') ? 'active' : '' }}" href="/wilayah">Wilayah</a>
                    </nav>
                </div>
                @endif

                @include('components.main-menu-admin-divisi')

                @include('components.main-menu-user')

                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <div class="sidenav-menu-heading">Pengaturan</div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="false" aria-controls="collapseSetting">
                    <div class="nav-link-icon"><i data-feather="sliders"></i></div>
                    Pengaturan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSetting" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/setting/dashboard">Judul dashboard</a>
                        <a class="nav-link" href="/setting/lokasi-absen">Lokasi absen</a></a>
                        <a class="nav-link" href="/periode">Periode roster</a>
                        <a class="nav-link" href="/setting/waktu-absen">Waktu absen</a>
                        <a class="nav-link" href="/setting/pasal">Pasal</a>
                    </nav>
                </div>
                @endif
            </div>
        </div>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Masuk sebagai :</div>
                <div class="sidenav-footer-title">{{ Auth::user()->employee->nama_karyawan }}</div>
            </div>
        </div>
    </nav>
</div>