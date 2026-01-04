@if(strtolower(Auth::user()->job->permission_role ?? '') == '')

<div class="sidenav-menu-heading text-uppercase small text-muted fw-semibold mt-3">
	Main Menu
</div>

<!-- Permohonan Cuti -->
<a class="nav-link d-flex align-items-center {{ request()->is('ess/cuti*') ? '' : 'collapsed' }}"
	href="javascript:void(0);"
	data-bs-toggle="collapse"
	data-bs-target="#collapseKelolaCuti"
	aria-expanded="{{ request()->is('ess/cuti*') ? 'true' : 'false' }}">

	<div class="nav-link-icon me-2">
		<i data-feather="log-out"></i>
	</div>
	<span class="flex-grow-1">Cuti</span>
	<i class="fas fa-chevron-down small"></i>
</a>

<div class="collapse {{ request()->is('ess/cuti*') ? 'show' : '' }}"
	id="collapseKelolaCuti"
	data-bs-parent="#accordionSidenav">
	<nav class="sidenav-menu-nested nav flex-column ms-4">
		<a class="nav-link {{ request()->is('ess/cuti-roster') ? 'active' : '' }}" href="/ess/cuti-roster">
			Roster
		</a>
		<a class="nav-link {{ request()->is('ess/cuti-tahunan') ? 'active' : '' }}" href="/ess/cuti-tahunan">
			Tahunan
		</a>
	</nav>
</div>

<a class="nav-link d-flex align-items-center {{ request()->is('ess/izin-dibayarkan','ess/izin-tidak-dibayarkan') ? '' : 'collapsed' }}"
	href="javascript:void(0);"
	data-bs-toggle="collapse"
	data-bs-target="#collapseKelolaIzin"
	aria-expanded="{{ request()->is('ess/izin-dibayarkan','ess/izin-tidak-dibayarkan') ? 'true' : 'false' }}">

	<div class="nav-link-icon me-2">
		<i data-feather="calendar"></i>
	</div>
	<span class="flex-grow-1">Izin</span>
	<i class="fas fa-chevron-down small"></i>
</a>

<div class="collapse {{ request()->is('ess/izin-dibayarkan','ess/izin-tidak-dibayarkan') ? 'show' : '' }}"
	id="collapseKelolaIzin"
	data-bs-parent="#accordionSidenav">
	<nav class="sidenav-menu-nested nav flex-column ms-4">
		<a class="nav-link {{ request()->is('ess/izin-dibayarkan') ? 'active' : '' }}" href="/ess/izin-dibayarkan">
			Berbayar
		</a>
		<a class="nav-link {{ request()->is('ess/izin-tidak-dibayarkan') ? 'active' : '' }}" href="/ess/izin-tidak-dibayarkan">
			Tidak Berbayar
		</a>
	</nav>
</div>

<!-- Status Pengajuan -->
<a class="nav-link d-flex align-items-center {{ request()->is('ess/status*') ? '' : 'collapsed' }}"
	href="javascript:void(0);"
	data-bs-toggle="collapse"
	data-bs-target="#collapseStatusPengajuan"
	aria-expanded="{{ request()->is('ess/status*') ? 'true' : 'false' }}">

	<div class="nav-link-icon me-2">
		<i data-feather="check-circle"></i>
	</div>
	<span class="flex-grow-1">Status Pengajuan</span>
	<i class="fas fa-chevron-down small"></i>
</a>

<div class="collapse {{ request()->is('ess/status*') ? 'show' : '' }}"
	id="collapseStatusPengajuan"
	data-bs-parent="#accordionSidenav">
	<nav class="sidenav-menu-nested nav flex-column ms-4">
		<a class="nav-link {{ request()->is('ess/status/roster') ? 'active' : '' }}" href="/ess/status/roster">
			Cuti Roster
		</a>
		<a class="nav-link {{ request()->is('ess/status/pengajuan') ? 'active' : '' }}" href="/ess/status/pengajuan">
			Cuti Tahunan & Izin
		</a>
	</nav>
</div>

<!-- Single Menu -->
<a class="nav-link {{ request()->is('ess/slip-gaji') ? 'active' : '' }}" href="/ess/slip-gaji">
	<div class="nav-link-icon me-2">
		<i data-feather="credit-card"></i>
	</div>
	Slip Gaji
</a>

<a class="nav-link {{ request()->is('ess/lembur') ? 'active' : '' }}" href="/ess/lembur">
	<div class="nav-link-icon me-2">
		<i data-feather="clock"></i>
	</div>
	Permintaan Lembur
</a>

<a class="nav-link {{ request()->is('ess/kehadiran') ? 'active' : '' }}" href="/ess/kehadiran">
	<div class="nav-link-icon me-2">
		<i data-feather="map-pin"></i>
	</div>
	Kehadiran
</a>

<a class="nav-link {{ request()->is('ess/tiket') ? 'active' : '' }}" href="/ess/tiket">
	<div class="nav-link-icon me-2">
		<i data-feather="inbox"></i>
	</div>
	Tiket
</a>
@endif