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
                <div class="sidenav-menu-heading">Core</div>
                <a class="nav-link {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}" href="/dashboard">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <a class="nav-link {{ (request()->segment(1) == 'audit-trails') ? 'active' : '' }}" href="/audit-trails">
                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                    Jejak aktivitas
                </a>
                <div class="sidenav-menu-heading">HR</div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Pengguna
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'users') ? 'show' : '' }}" id="collapseUsers" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('users', 'users')) ? 'active' : '' }}" href="/users">Data Pengguna</a>
                        <a class="nav-link {{ (request()->segment(2) == 'last-login') ? 'active' : '' }}" href="/users/last-login">Riwayat masuk</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmployees" aria-expanded="false" aria-controls="collapseEmployees">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Karyawan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'employees' || request()->segment(1) == 'roles') ? 'show' : '' }}" id="collapseEmployees" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavemployee">
                        <a class="nav-link {{ (request()->is('employees', 'employees')) ? 'active' : '' }}" href="{{ url('employees')}}">Data karyawan</a>
                        <!-- <a class="nav-link {{ (request()->segment(1) == 'roles') ? 'active' : '' }}" href="/roles">Peran dan akses</a> -->
                        <a class="nav-link {{ (request()->segment(2) == 'import') ? 'active' : '' }}" href="/employees/import">Impor karyawan</a>
                    </nav>
                </div>

                <a class="nav-link {{ (request()->segment(1) == 'perusahaan') ? 'active' : '' }}" href="/perusahaan">
                    <div class="nav-link-icon"><i data-feather="codepen"></i></div>
                    Perusahaan
                </a>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCoreHr" aria-expanded="false" aria-controls="collapseCoreHr">
                    <div class="nav-link-icon"><i data-feather="link-2"></i></div>
                    Hubungan Industrial
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'industrial-relations') ? 'show' : '' }}" id="collapseCoreHr" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('contract', 'contract')) ? 'active' : '' }}" href="/contract">PKWT 1</a>
                        <a class="nav-link {{ (request()->segment(2) == 'severance-pay') ? 'active' : '' }}" href="/industrial-relations/severance-pay">Pesangon</a>
                        <a class="nav-link {{ (request()->segment(2) == 'sp-report') ? 'active' : '' }}" href="/industrial-relations/sp-report">Peringatan</a>
                        <a class="nav-link {{ (request()->segment(2) == 'resign') ? 'active' : '' }}" href="/industrial-relations/resign">Pengunduran diri</a>
                    </nav>
                </div>

                <!-- <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePayroll" aria-expanded="false" aria-controls="collapsePayroll">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Penggajian
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'salary') ? 'show' : '' }}" id="collapsePayroll" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/salary/employee">Employee Salary</a>
                        <a class="nav-link {{ (request()->segment(1) == 'salary' && request()->segment(2) == 'payslip') ? 'active' : '' }}" href="/salary/payslip">Slip gaji</a>
                        <a class="nav-link {{ (request()->segment(1) == 'salary' && request()->segment(2) == '') ? 'active' : '' }}" href="/salary">Impor slip gaji</a>
                        <a class="nav-link {{ (request()->segment(1) == 'salary' && request()->segment(2) == 'history') ? 'active' : '' }}" href="/salary/history">Riwayat impor</a>
                    </nav>
                </div> -->

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Keuntungan dan Manfaat
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'pengajuan-karyawan' || request()->segment(1) == 'roster' || request()->segment(3) == 'all-in') ? 'show' : '' }}" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->segment(1) == 'pengajuan-karyawan') ? 'active' : '' }}" href="/pengajuan-karyawan">Cuti & Izin</a>
                        <a class="nav-link {{ (request()->segment(1) == 'roster' && request()->segment(2) == '') ? 'active' : '' }}" href="/roster">Cuti Roster</a>
                        <a class="nav-link {{ (request()->segment(2) == 'daftar-pengingat') ? 'active' : '' }}" href="/roster/daftar-pengingat">Pengingat</a>
                        <a class="nav-link {{ (request()->segment(3) == 'all-in') ? 'active' : '' }}" href="/absen/detail/all-in">Absensi</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
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



                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'admin divisi')
                <div class="sidenav-menu-heading">Main menu</div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Pengajuan karyawan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'pengajuan-karyawan' || request()->segment(1) == 'roster' || request()->segment(3) == 'all-in') ? 'show' : '' }}" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->segment(1) == 'pengajuan-karyawan') ? 'active' : '' }}" href="/admin/cuti/">Cuti dan izin</a>
                        <a class="nav-link {{ (request()->segment(3) == 'permohonan' && request()->segment(2) == 'roster') ? 'active' : '' }}" href="/admin/roster/permohonan">Cuti roster</a>
                    </nav>
                </div>
                <a class="nav-link {{ (request()->segment(3) == '' && request()->segment(2) == 'roster') ? 'active' : '' }}" href="/admin/roster/">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Pengingat
                </a>
                @endif

                @if(strtolower(Auth::user()->job->permission_role ?? '') == '')

                <div class="sidenav-menu-heading">Main menu</div>

                <a class="nav-link {{ (request()->segment(2) == 'pengajuan' || request()->segment(2) == 'status-permohonan') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseStatusPengajuan" aria-expanded="false" aria-controls="collapseStatusPengajuan">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Status pengajuan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(2) == 'status-permohonan' || request()->segment(2) == 'pengajuan') ? 'show' : '' }}" id="collapseStatusPengajuan" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->segment(2) == 'status-permohonan') ? 'active' : '' }}" href="/karyawan/status-permohonan">Cuti roster</a>
                        <a class="nav-link {{ (request()->segment(2) == 'pengajuan') ? 'active' : '' }}" href="/account/pengajuan">Cuti tahunan dan izin</a>
                    </nav>
                </div>
                <a class="nav-link {{ (request()->segment(1) == 'karyawan' && request()->segment(2) == '') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Pengajuan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'karyawan' && request()->segment(2) == '') ? 'show' : '' }}" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->segment(2) == 'cuti' && request()->segment(3) == 'roster') ? 'active' : '' }}" href="/karyawan/cuti/roster">Cuti roster</a>
                        <a class="nav-link {{ (request()->segment(2) == 'cuti' && request()->segment(3) == '') ? 'active' : '' }}" href="/karyawan/cuti">Cuti tahunan</a>
                        <a class="nav-link {{ (request()->segment(2) == 'izin-dibayarkan' && request()->segment(3) == '') ? 'active' : '' }}" href="/karyawan/izin-dibayarkan">Izin berbayar</a>
                        <a class="nav-link {{ (request()->segment(2) == 'izin-tidak-dibayarkan' && request()->segment(3) == '') ? 'active' : '' }}" href="/karyawan/izin-tidak-dibayarkan">Izin tidak berbayar</a>
                    </nav>
                </div>
                <a class="nav-link {{ (request()->segment(1) == 'absen') ? 'active' : '' }}" href="/absen">
                    <div class="nav-link-icon"><i data-feather="map-pin"></i></div>
                    Presensi
                </a>
                <a class="nav-link {{ (request()->segment(1) == 'tiket') ? 'active' : '' }}" href="/tiket">
                    <div class="nav-link-icon"><i data-feather="file"></i></div>
                    Tiket
                </a>
                @endif

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