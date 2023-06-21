<div id="layoutSidenav_nav">
    <nav class="sidenav sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Account)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <div class="sidenav-menu-heading d-sm-none">Pemberitahuan</div>
                <a class="nav-link d-sm-none" href="/roster/daftar-pengingat">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Daftar Cuti
                    @if(getCountPengingat() > 0)
                    <span class="badge bg-success-soft text-success ms-auto">{{ getCountPengingat() }} New!</span>
                    @endif
                </a>
                @endif
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
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="/dashboard">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <!-- Sidenav Audit Trails (Audit) -->
                <a class="nav-link" href="/audit-trails">
                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                    Riwayat Audit
                </a>
                <div class="sidenav-menu-heading">Master Menu</div>
                <!-- Sidenav Accordion (Users)-->
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
                <!-- Sidenav Accordion (Employees)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmployees" aria-expanded="false" aria-controls="collapseEmployees">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Karyawan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEmployees" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavemployee">
                        <a class="nav-link" href="{{ url('employees')}}">Data Karyawan</a>
                        <a class="nav-link" href="/roles">Jabatan Karyawan</a>
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
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseCoreHr" aria-expanded="false" aria-controls="pagesCollapseCoreHr">
                            Kontrak
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseCoreHr" data-bs-parent="#accordionSidenavPagesMenu">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="/contract">PKWT 1</a>
                                <a class="nav-link" href="/contract">PKWT Lanjutan</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseTraining" aria-expanded="false" aria-controls="pagesCollapseTraining">
                            Pelatihan
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseTraining" data-bs-parent="#accordionSidenavPagesMenu">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="/pengembangan">Data Pelatihan</a>
                                <a class="nav-link" href="/pengembangan">Tipe Pelatihan</a>
                                <a class="nav-link" href="/pengembangan">Data Pelatih</a>
                            </nav>
                        </div>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Payslip) -->
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
                    Kompensasi dan Keuntungan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/roster">Kalender Translator</a>
                        <a class="nav-link" href="/roster/aktif">Pengingat</a>
                        <a class="nav-link" href="/absen/detail">Absensi</a>
                    </nav>
                </div>
                @endif
                <div class="sidenav-menu-heading">ESS</div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKehadiran" aria-expanded="false" aria-controls="collapseKehadiran">
                    <div class="nav-link-icon"><i data-feather="log-in"></i></div>
                    Kehadiran
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseKehadiran" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/absen">Absen</a>
                </div>
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <div class="sidenav-menu-heading">Pengaturan</div>
                <!-- Sidenav Accordion (Applications)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="false" aria-controls="collapseSetting">
                    <div class="nav-link-icon"><i data-feather="sliders"></i></div>
                    Sesuaikan Pengaturan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSetting" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/setting/dashboard">Judul Dashboard</a>
                        <a class="nav-link" href="/setting/lokasi-absen">Lokasi Absen</a></a>
                        <a class="nav-link" href="/periode-absen">Periode Absen</a></a>
                        <a class="nav-link" href="/periode">Periode Roster</a>
                        <a class="nav-link" href="/setting/waktu-absen">Waktu Kerja</a>
                </div>
                @endif
            </div>

        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->employee->nama_karyawan }}</div>
            </div>
        </div>
    </nav>
</div>