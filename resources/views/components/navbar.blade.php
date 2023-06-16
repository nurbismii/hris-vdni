<ul class="navbar-nav align-items-center ms-auto">
    <!-- Documentation Dropdown-->
    <li class="nav-item dropdown no-caret d-none d-md-block me-3">
        <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="small text-gray-800">{{ date('d F Y') }}</div>
            <div class="mx-1"></div>
            <div id="time" class="small text-gray-800"></div>
        </a>
    </li>
    <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
        <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i></a>
        <div class="dropdown-menu dropdown-menu-end border-0 animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
            <h6 class="dropdown-header dropdown-notifications-header">
                <i class="me-2" data-feather="bell"></i>
                Pengingat
            </h6>
            @foreach(getNotifPengingat() as $data)
            <a class="dropdown-item dropdown-notifications-item" data-bs-toggle="modal" data-bs-target="#pengingat{{$data->id}}">
                <div class="dropdown-notifications-item-icon bg-danger"><i data-feather="bell"></i></div>
                <div class="dropdown-notifications-item-content">
                    <div class="dropdown-notifications-item-content-details">{{ date('d F Y', strtotime($data['tanggal_cuti'])) }}</div>
                    <div class="dropdown-notifications-item-content-text">{{ getName($data['nik_karyawan']) }}</div>
                </div>
            </a>
            @endforeach
            <a class="dropdown-item dropdown-notifications-footer" href="/lihat-pengingat">Lihat semua</a>
        </div>
    </li>

    <!-- <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
        <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="mail"></i></a>
        <div class="dropdown-menu dropdown-menu-end border-0 animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
            <h6 class="dropdown-header dropdown-notifications-header">
                <i class="me-2" data-feather="mail"></i>
                Pusat Pesan
            </h6>
            <a class="dropdown-item dropdown-notifications-item" href="#!">
                <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-2.png') }}" />
                <div class="dropdown-notifications-item-content">
                    <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                    <div class="dropdown-notifications-item-content-details">Thomas Wilcox · 58m</div>
                </div>
            </a>
            <a class="dropdown-item dropdown-notifications-item" href="#!">
                <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-3.png') }}" />
                <div class="dropdown-notifications-item-content">
                    <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                    <div class="dropdown-notifications-item-content-details">Emily Fowler · 2d</div>
                </div>
            </a>
            <a class="dropdown-item dropdown-notifications-item" href="#!">
                <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-4.png') }}" />
                <div class="dropdown-notifications-item-content">
                    <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                    <div class="dropdown-notifications-item-content-details">Marshall Rosencrantz · 3d</div>
                </div>
            </a>
            <a class="dropdown-item dropdown-notifications-item" href="#!">
                <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-5.png') }}" />
                <div class="dropdown-notifications-item-content">
                    <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                    <div class="dropdown-notifications-item-content-details">Colby Newton · 3d</div>
                </div>
            </a>
            <a class="dropdown-item dropdown-notifications-footer" href="#!">Read All Messages</a>
        </div>
    </li> -->

    <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
        <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="globe"></i></a>
        <div class="dropdown-menu dropdown-menu-end border-0 animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
            <h6 class="dropdown-header dropdown-notifications-header">
                <i class="me-2" data-feather="globe"></i>
                Pilih bahasa
            </h6>
            <a class="lang-select dropdown-item dropdown-notifications-item" data-lang="id" href="#googtrans(en|id)">
                <div class="dropdown-notifications-item-content">
                    <div class="dridopdown-notifications-item-content-text">Indonesia</div>
                </div>
            </a>
            <a class="lang-select dropdown-item dropdown-notifications-item" data-lang="zh" href="#googtrans(en|zh-CN)">
                <div class="dropdown-notifications-item-content">
                    <div class="dridopdown-notifications-item-content-text">Mandarin (Sederhana)</div>
                </div>
            </a>
        </div>
    </li>

    <!-- User Dropdown-->
    <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
        <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" /></a>
        <div class="dropdown-menu dropdown-menu-end border-0 animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
            <h6 class="dropdown-header d-flex align-items-center">
                <img class="dropdown-user-img" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" />
                <div class="dropdown-user-details">
                    <div class="dropdown-user-details-name">{{ Auth::user()->employee->nama_karyawan }}</div>
                    <div class="dropdown-user-details-email">{{ Auth::user()->email }}</div>
                </div>
            </h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/account/profile">
                <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                Akun
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
</ul>