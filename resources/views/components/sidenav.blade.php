<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                @if(strtolower(Auth::user()->job->permission_role ?? '') != 'administrator')
                <div class="sidenav-menu-heading d-sm-none">Pemberitahuan</div>
                <a class="nav-link d-sm-none" href="/lihat-pengingat">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Pengingat
                    @if(getCountPengingat() > 0)
                    <span class="badge bg-success-soft text-success ms-auto">{{ getCountPengingat() }} New!</span>
                    @endif
                </a>
                @endif
                <div class="sidenav-menu-heading">Core</div>
                <a class="nav-link" href="/dashboard">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <a class="nav-link" href="/audit-trails">
                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                    Riwayat Audit
                </a>
                <div class="sidenav-menu-heading">Master Menu</div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Pengguna
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsers" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/users">Data Pengguna</a>
                        <a class="nav-link" href="/users/last-login">Riwayat Login</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmployees" aria-expanded="false" aria-controls="collapseEmployees">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Karyawan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEmployees" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavemployee">
                        <a class="nav-link" href="{{ url('employees')}}">Data Karyawan</a>
                        <a class="nav-link" href="/roles">Akses Karyawan</a>
                        <a class="nav-link" href="/employees/import">Impor Karyawan</a>
                    </nav>
                </div>

                <a class="nav-link" href="/departemen">
                    <div class="nav-link-icon"><i data-feather="codepen"></i></div>
                    Departemen
                </a>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCoreHr" aria-expanded="false" aria-controls="collapseCoreHr">
                    <div class="nav-link-icon"><i data-feather="link-2"></i></div>
                    Hubungan Industrial
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCoreHr" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/contract">Data PKWT 1</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePayroll" aria-expanded="false" aria-controls="collapsePayroll">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Slip Gaji
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePayroll" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/salary/slip-gaji">Data Slip Gaji</a>
                        <a class="nav-link" href="/salary">Impor Slip Gaji</a>
                        <a class="nav-link" href="/salary/history">Riwayat Impor</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Comben
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/roster">Data Roster</a>
                        <a class="nav-link" href="/pengajuan-karyawan">Data Pengajuan Cuti</a>
                        <a class="nav-link" href="/roster/aktif">Data Pengingat Cuti</a>
                        <a class="nav-link" href="/absen/detail/all-in">Data Absensi</a>
                    </nav>
                </div>
                @endif
                <div class="sidenav-menu-heading">ESS</div>

                <a class="nav-link" href="/absen">
                    <div class="nav-link-icon"><i data-feather="log-in"></i></div>
                    Presensi
                </a>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCuti" aria-expanded="false" aria-controls="collapseCuti">
                    <div class="nav-link-icon"><i data-feather="edit-3"></i></div>
                    Cuti
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengajuan/cuti">Cuti Tahunan</a>
                        <a class="nav-link" href="">Izin Dibayarkan</a>
                        <a class="nav-link" href="">Izin Tidak Dibayarkan</a>
                    </nav>
                </div>
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <div class="sidenav-menu-heading">Pengaturan</div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="false" aria-controls="collapseSetting">
                    <div class="nav-link-icon"><i data-feather="sliders"></i></div>
                    Pengaturan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSetting" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/setting/dashboard">Judul Dashboard</a>
                        <a class="nav-link" href="/setting/lokasi-absen">Lokasi Presensi</a></a>
                        <a class="nav-link" href="/periode">Periode Roster</a>
                        <a class="nav-link" href="/setting/waktu-absen">Waktu Kerja</a>
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