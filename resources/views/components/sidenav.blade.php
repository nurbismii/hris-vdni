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
                    Messages
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link" href="/">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                <!-- Sidenav Audit Trails (Audit) -->
                <a class="nav-link" href="/">
                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                    Audit Trails
                </a>
                <!-- Sidenav Heading (Master Menu)-->
                <div class="sidenav-menu-heading">Master Menu</div>
                <!-- Sidenav Accordion (Users)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Users
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsers" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/users">User List</a>
                        <a class="nav-link" href="/roles">Assign Role</a>
                        <a class="nav-link" href="account-security.html">User Last Login</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Employees)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEmployees" aria-expanded="false" aria-controls="collapseEmployees">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Employees
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEmployees" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="/employees">Employee list</a>
                        <a class="nav-link" href="/employees/import">Employee Import</a>
                        <a class="nav-link" href="/#">Employee Assessment</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Applications)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseApps" aria-expanded="false" aria-controls="collapseApps">
                    <div class="nav-link-icon"><i data-feather="sliders"></i></div>
                    Customize Setting
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseApps" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="account-billing.html">Mail Setting</a>
                </div>
                <!-- Sidenav Accordion (Flows)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
                    <div class="nav-link-icon"><i data-feather="cpu"></i></div>
                    Core HR
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseFlows" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Promotion</a>
                        <a class="nav-link" href="wizard.html">Award</a>
                        <a class="nav-link" href="wizard.html">Travel</a>
                        <a class="nav-link" href="wizard.html">Transfer</a>
                        <a class="nav-link" href="wizard.html">Resignations</a>
                        <a class="nav-link" href="wizard.html">Complaints</a>
                        <a class="nav-link" href="wizard.html">Warnings</a>
                        <a class="nav-link" href="wizard.html">Terminations</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Timesheets) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseTimesheets" aria-expanded="false" aria-controls="collapseTimesheets">
                    <div class="nav-link-icon"><i data-feather="clock"></i></div>
                    Timesheets
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTimesheets" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Add | Update Attedances</a>
                        <a class="nav-link" href="wizard.html">Import Attendances</a>
                        <a class="nav-link" href="wizard.html">Office Shift</a>
                        <a class="nav-link" href="wizard.html">Manage Holiday</a>
                        <a class="nav-link" href="wizard.html">Manage Leaves</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Payroll) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePayroll" aria-expanded="false" aria-controls="collapsePayroll">
                    <div class="nav-link-icon"><i data-feather="credit-card"></i></div>
                    Payroll
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePayroll" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">New Payment</a>
                        <a class="nav-link" href="wizard.html">Payment Histroy</a>
                    </nav>
                </div>
                <!-- Sidanav Accordion (Performance) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePerform" aria-expanded="false" aria-controls="collapsePerform">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Employee Performance
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePerform" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Goal Type</a>
                        <a class="nav-link" href="wizard.html">Goal Tracking</a>
                        <a class="nav-link" href="wizard.html">Indicator</a>
                        <a class="nav-link" href="wizard.html">Apraisal</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Calendar) -->
                <a class="nav-link" href="charts.html">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    HR Calendar
                </a>
                <!-- Sidanav Accordion (Recruitment) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRecruitment" aria-expanded="false" aria-controls="collapseRecruitment">
                    <div class="nav-link-icon"><i data-feather="user-plus"></i></div>
                    Recruitment
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseRecruitment" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Job Post</a>
                        <a class="nav-link" href="wizard.html">Job Candidates</a>
                        <a class="nav-link" href="wizard.html">Job Interview</a>
                        <a class="nav-link" href="wizard.html">CMS</a>
                    </nav>
                </div>
                <!-- Sidanav Accordion (Training list) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseTraining" aria-expanded="false" aria-controls="collapseTraining">
                    <div class="nav-link-icon"><i data-feather="menu"></i></div>
                    Training List
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTraining" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Training List</a>
                        <a class="nav-link" href="wizard.html">Training Type</a>
                        <a class="nav-link" href="wizard.html">Trainers</a>
                    </nav>
                </div>
                <!-- Sidanav Accordion (Event Meeting) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMeeting" aria-expanded="false" aria-controls="collapseMeeting">
                    <div class="nav-link-icon"><i data-feather="monitor"></i></div>
                    Event Meeting
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMeeting" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Events</a>
                        <a class="nav-link" href="wizard.html">Meetings</a>
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
                        <a class="nav-link" href="multi-tenant-select.html">Project</a>
                        <a class="nav-link" href="wizard.html">Tasks</a>
                        <a class="nav-link" href="wizard.html">Client</a>
                        <a class="nav-link" href="wizard.html">Invoice</a>
                        <a class="nav-link" href="wizard.html">Tax Type</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Calendar) -->
                <a class="nav-link" href="charts.html">
                    <div class="nav-link-icon"><i data-feather="printer"></i></div>
                    Support Tickets
                </a>
                <!-- Sidanav Accordion (Finance) -->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFinance" aria-expanded="false" aria-controls="collapseFinance">
                    <div class="nav-link-icon"><i data-feather="trending-up"></i></div>
                    Finance
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseFinance" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Account List</a>
                        <a class="nav-link" href="wizard.html">Account Balances</a>
                        <a class="nav-link" href="wizard.html">Payee</a>
                        <a class="nav-link" href="wizard.html">Payer</a>
                        <a class="nav-link" href="wizard.html">Deposit</a>
                        <a class="nav-link" href="wizard.html">Expense</a>
                        <a class="nav-link" href="wizard.html">Transaction</a>
                        <a class="nav-link" href="wizard.html">Transfer</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseAssets" aria-expanded="false" aria-controls="collapseAssets">
                    <div class="nav-link-icon"><i data-feather="box"></i></div>
                    Assets
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAssets" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Category</a>
                        <a class="nav-link" href="wizard.html">Assets</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFileManager" aria-expanded="false" aria-controls="collapseFileManager">
                    <div class="nav-link-icon"><i data-feather="file"></i></div>
                    File Manager
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseFileManager" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="multi-tenant-select.html">Category</a>
                        <a class="nav-link" href="wizard.html">Assets</a>
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