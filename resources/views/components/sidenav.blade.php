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
                    Jejak Aktivitas
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
                        <a class="nav-link {{ (request()->segment(1) == 'roles') ? 'active' : '' }}" href="/roles">Peran dan akses</a>
                        <a class="nav-link {{ (request()->segment(2) == 'import') ? 'active' : '' }}" href="/employees/import">Impor karyawan</a>
                    </nav>
                </div>

                <a class="nav-link {{ (request()->segment(1) == 'departemen') ? 'active' : '' }}" href="/departemen">
                    <div class="nav-link-icon"><i data-feather="codepen"></i></div>
                    Departmen
                </a>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCoreHr" aria-expanded="false" aria-controls="collapseCoreHr">
                    <div class="nav-link-icon"><i data-feather="link-2"></i></div>
                    Hubungan Industrial
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'industrial-relations') ? 'show' : '' }}" id="collapseCoreHr" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('contract', 'contract')) ? 'active' : '' }}" href="/contract">PKWT</a>
                        <a class="nav-link {{ (request()->segment(2) == 'severance-pay') ? 'active' : '' }}" href="/industrial-relations/severance-pay">Pesangon</a>
                        <a class="nav-link {{ (request()->segment(2) == 'sp-report') ? 'active' : '' }}" href="/industrial-relations/sp-report">Peringatan</a>
                        <a class="nav-link {{ (request()->segment(2) == 'resign') ? 'active' : '' }}" href="/industrial-relations/resign">Resign</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePayroll" aria-expanded="false" aria-controls="collapsePayroll">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Penggajian
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->segment(1) == 'salary') ? 'show' : '' }}" id="collapsePayroll" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <!-- <a class="nav-link" href="/salary/employee">Employee Salary</a> -->
                        <a class="nav-link {{ (request()->segment(1) == 'salary' && request()->segment(2) == 'payslip') ? 'active' : '' }}" href="/salary/payslip">Slip gaji</a>
                        <a class="nav-link {{ (request()->segment(1) == 'salary' && request()->segment(2) == '') ? 'active' : '' }}" href="/salary">Impor slip gaji</a>
                        <a class="nav-link {{ (request()->segment(1) == 'salary' && request()->segment(2) == 'history') ? 'active' : '' }}" href="/salary/history">Riwayat impor</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Keuntungan dan manfaat
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
                @endif
                <div class="sidenav-menu-heading">Main menu</div>

                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'admin divisi')
                <a class="nav-link {{ (request()->segment(1) == 'admin' || request()->segment(2) == 'roster') ? 'active' : '' }}" href="/admin/roster">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Cuti Roster
                </a>
                <a class="nav-link {{ (request()->segment(1) == 'admin' || request()->segment(2) == 'cuti') ? 'active' : '' }}" href="/admin/cuti">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Cuti & izin
                </a>
                @endif
                <a class="nav-link {{ (request()->segment(1) == 'absen') ? 'active' : '' }}" href="/absen">
                    <div class="nav-link-icon"><i data-feather="map-pin"></i></div>
                    Presensi
                </a>

                <a class="nav-link {{ (request()->segment(1) == 'tiket') ? 'active' : '' }}" href="/tiket">
                    <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                    Tiket
                </a>
                <!-- <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCuti" aria-expanded="false" aria-controls="collapseCuti">
                    <div class="nav-link-icon"><i data-feather="edit-3"></i></div>
                    Pengajuan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengajuan/cuti">Cuti tahunan</a>
                        <a class="nav-link" href="/pengajuan/izin-dibayarkan">Izin dibayarkan</a>
                        <a class="nav-link" href="/pengajuan/izin-tidak-dibayarkan">Izin tidak dibayarkan</a>
                    </nav>
                </div> -->
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