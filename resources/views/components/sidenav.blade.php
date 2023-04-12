<div id="layoutSidenav_nav">
    <nav class="sidenav sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Account)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <!-- Sidenav Link (Alerts)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Alerts
                    <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                </a>
                <!-- Sidenav Link (Messages)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="mail"></i></div>
                    Pesan
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="/dashboard">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                <!-- Sidenav Audit Trails (Audit) -->
                <a class="nav-link" href="/audit-trails">
                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                    Jejak Audit
                </a>
                <!-- Sidenav Heading (Master Menu)-->
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
                        <a class="nav-link" href="/users/last-login">Pengguna jejak login</a>
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
                        <a class="nav-link" href="/employees">Daftar Karyawan</a>
                        <a class="nav-link" href="/roles">Jabatan Karyawan</a>
                        <a class="nav-link" href="/employees/import">Impor Karyawan</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Applications)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseApps" aria-expanded="false" aria-controls="collapseApps">
                    <div class="nav-link-icon"><i data-feather="sliders"></i></div>
                    Menyesuaikan pengaturan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseApps" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/setting/dashboard">Konten Dashboard</a>
                        <a class="nav-link" href="/pengembangan">Pengaturan Email</a>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCoreHr" aria-expanded="false" aria-controls="collapseCoreHr">
                    <div class="nav-link-icon"><i data-feather="cpu"></i></div>
                    HR
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
                                <a class="nav-link" href="/contract">PKWT Langkah ke-1</a>
                                <a class="nav-link" href="/contract">PKWT Lanjutan</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapseTraining" aria-expanded="false" aria-controls="pagesCollapseTraining">
                            Training
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseTraining" data-bs-parent="#accordionSidenavPagesMenu">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="/pengembangan">Training List</a>
                                <a class="nav-link" href="/pengembangan">Training Type</a>
                                <a class="nav-link" href="/pengembangan">Trainers</a>
                            </nav>
                        </div>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseTimesheets" aria-expanded="false" aria-controls="collapseTimesheets">
                    <div class="nav-link-icon"><i data-feather="clock"></i></div>
                    Timesheets
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTimesheets" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Add | Update Attedances</a>
                        <a class="nav-link" href="/pengembangan">Import Attendances</a>
                        <a class="nav-link" href="/pengembangan">Office Shift</a>
                        <a class="nav-link" href="/pengembangan">Manage Holiday</a>
                        <a class="nav-link" href="/pengembangan">Manage Leaves</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Payslip) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePayroll" aria-expanded="false" aria-controls="collapsePayroll">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Payslip
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePayroll" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/salary">Impor Payslip</a>
                        <a class="nav-link" href="/salary/history">Jejak impor</a>
                    </nav>
                </div>
                <!-- Sidanav Accordion (Performance) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePerform" aria-expanded="false" aria-controls="collapsePerform">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Kinerja Karyawan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePerform" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengembangan">Goal Type</a>
                        <a class="nav-link" href="/pengembangan">Goal Tracking</a>
                        <a class="nav-link" href="/pengembangan">Indicator</a>
                        <a class="nav-link" href="/pengembangan">Apraisal</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Calendar) -->
                <a class="nav-link" href="charts.html">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    HR Kalender
                </a>
                <!-- Sidanav Accordion (Recruitment) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRecruitment" aria-expanded="false" aria-controls="collapseRecruitment">
                    <div class="nav-link-icon"><i data-feather="user-plus"></i></div>
                    Rekrutmen
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseRecruitment" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengembangan">Job Post</a>
                        <a class="nav-link" href="/pengembangan">Job Candidates</a>
                        <a class="nav-link" href="/pengembangan">Job Interview</a>
                        <a class="nav-link" href="/pengembangan">CMS</a>
                    </nav>
                </div>
                <!-- Sidanav Accordion (Event Meeting) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMeeting" aria-expanded="false" aria-controls="collapseMeeting">
                    <div class="nav-link-icon"><i data-feather="monitor"></i></div>
                    Agenda Meeting
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMeeting" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengembangan">Events</a>
                        <a class="nav-link" href="/pengembangan">Meetings</a>
                    </nav>
                </div>
                <!-- Sidanav Accordion (Event Meeting) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseProjectManagement" aria-expanded="false" aria-controls="collapseProjectManagement">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    Project Management
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProjectManagement" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengembangan">Project</a>
                        <a class="nav-link" href="/pengembangan">Tasks</a>
                        <a class="nav-link" href="/pengembangan">Client</a>
                        <a class="nav-link" href="/pengembangan">Invoice</a>
                        <a class="nav-link" href="/pengembangan">Tax Type</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Calendar) -->
                <a class="nav-link" href="charts.html">
                    <div class="nav-link-icon"><i data-feather="printer"></i></div>
                    Support Tickets
                </a>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFileManager" aria-expanded="false" aria-controls="collapseFileManager">
                    <div class="nav-link-icon"><i data-feather="file"></i></div>
                    File Manager
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseFileManager" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/pengembangan">Category</a>
                        <a class="nav-link" href="/pengembangan">Assets</a>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </nav>
</div>