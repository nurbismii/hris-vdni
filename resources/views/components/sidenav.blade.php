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
                    Audit History
                </a>
                <div class="sidenav-menu-heading">HR</div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Users
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsers" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/users">Data user</a>
                        <a class="nav-link" href="/users/last-login">Login History</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmployees" aria-expanded="false" aria-controls="collapseEmployees">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Employees
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEmployees" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavemployee">
                        <a class="nav-link" href="{{ url('employees')}}">Data employee</a>
                        <a class="nav-link" href="/roles">Employee Access</a>
                        <a class="nav-link" href="/employees/import">Employee import</a>
                    </nav>
                </div>

                <a class="nav-link" href="/departemen">
                    <div class="nav-link-icon"><i data-feather="codepen"></i></div>
                    Department
                </a>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCoreHr" aria-expanded="false" aria-controls="collapseCoreHr">
                    <div class="nav-link-icon"><i data-feather="link-2"></i></div>
                    Industrial Relations
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCoreHr" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/contract">PKWT 1</a>
                        <a class="nav-link" href="/industrial-relations/severance-pay">Severance pay</a>
                        <a class="nav-link" href="#">SP Report</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePayroll" aria-expanded="false" aria-controls="collapsePayroll">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Payroll
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePayroll" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/salary/employee">Employee Salary</a>
                        <a class="nav-link" href="/salary/payslip">PaySlip</a>
                        <a class="nav-link" href="/salary">Import PaySlip</a>
                        <a class="nav-link" href="/salary/history">Import history</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Compensation and Benefits
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengajuan-karyawan">Leave application</a>
                        <a class="nav-link" href="/roster/aktif">Reminder</a>
                        <a class="nav-link" href="/absen/detail/all-in">Absensis</a>
                    </nav>
                </div>
                @endif
                <div class="sidenav-menu-heading">Main menu</div>

                <a class="nav-link" href="/absen">
                    <div class="nav-link-icon"><i data-feather="log-in"></i></div>
                    Precense
                </a>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCuti" aria-expanded="false" aria-controls="collapseCuti">
                    <div class="nav-link-icon"><i data-feather="edit-3"></i></div>
                    Submission
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCuti" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengajuan/cuti">Annual leave</a>
                        <a class="nav-link" href="/pengajuan/izin-dibayarkan">Permission paid</a>
                        <a class="nav-link" href="/pengajuan/izin-tidak-dibayarkan">Permission unpaid</a>
                    </nav>
                </div>
                @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                <div class="sidenav-menu-heading">Setting</div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="false" aria-controls="collapseSetting">
                    <div class="nav-link-icon"><i data-feather="sliders"></i></div>
                    Setting
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSetting" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/setting/dashboard">Content dashboard</a>
                        <a class="nav-link" href="/setting/lokasi-absen">Precense location</a></a>
                        <a class="nav-link" href="/periode">Roster period</a>
                        <a class="nav-link" href="/setting/waktu-absen">Working time</a>
                        <a class="nav-link" href="/setting/pasal">Pasal</a>
                </div>
                @endif
            </div>
        </div>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Login as :</div>
                <div class="sidenav-footer-title">{{ Auth::user()->employee->nama_karyawan }}</div>
            </div>
        </div>
    </nav>
</div>