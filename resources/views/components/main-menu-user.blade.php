@if(strtolower(Auth::user()->job->permission_role ?? '') == '')

<div class="sidenav-menu-heading">Main menu</div>

<!-- Pengajuan -->
<a class="nav-link {{ (request()->is('ess/cuti*') || request()->is('ess/izin-dibayarkan') || request()->is('ess/izin-tidak-dibayarkan')) ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="{{ (request()->is('ess/cuti*') || request()->is('ess/izin-dibayarkan') || request()->is('ess/izin-tidak-dibayarkan')) ? 'true' : 'false' }}" aria-controls="collapseKelolaCuti">
  <div class="nav-link-icon"><i data-feather="upload"></i></div>
  Pengajuan Cuti & Izin
  <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ (request()->is('ess/cuti*') || request()->is('ess/izin-dibayarkan') || request()->is('ess/izin-tidak-dibayarkan')) ? 'show' : '' }}" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
  <nav class="sidenav-menu-nested nav">
    <a class="nav-link {{ request()->is('ess/cuti/roster') ? 'active' : '' }}" href="/ess/cuti/roster">Cuti Roster</a>
    <a class="nav-link {{ request()->is('ess/cuti/tahunan') ? 'active' : '' }}" href="/ess/cuti/tahunan">Cuti Tahunan</a>
    <a class="nav-link {{ request()->is('ess/izin-dibayarkan') ? 'active' : '' }}" href="/ess/izin-dibayarkan">Izin Berbayar</a>
    <a class="nav-link {{ request()->is('ess/izin-tidak-dibayarkan') ? 'active' : '' }}" href="/ess/izin-tidak-dibayarkan">Izin Tidak Berbayar</a>
  </nav>
</div>

<!-- Status Pengajuan -->
<a class="nav-link {{ request()->is('ess/status*') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseStatusPengajuan" aria-expanded="{{ request()->is('ess/status*') ? 'true' : 'false' }}" aria-controls="collapseStatusPengajuan">
  <div class="nav-link-icon"><i data-feather="star"></i></div>
  Status Pengajuan
  <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ request()->is('ess/status*') ? 'show' : '' }}" id="collapseStatusPengajuan" data-bs-parent="#accordionSidenav">
  <nav class="sidenav-menu-nested nav">
    <a class="nav-link {{ request()->is('ess/status/permohonan') ? 'active' : '' }}" href="/ess/status/permohonan">Cuti Roster</a>
    <a class="nav-link {{ request()->is('ess/status/pengajuan') ? 'active' : '' }}" href="/ess/status/pengajuan">Cuti Tahunan dan Izin</a>
  </nav>
</div>



<a class="nav-link {{ request()->is('account/slip-gaji') ? 'active' : '' }}" href="/account/slip-gaji">
  <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
  Slip Gaji
</a>

<!-- Lembur -->
<a class="nav-link {{ request()->is('ess/lembur') ? 'active' : '' }}" href="/ess/lembur">
  <div class="nav-link-icon"><i data-feather="file-text"></i></div>
  Lembur
</a>

<!-- Presensi -->
<a class="nav-link {{ request()->is('absen') ? 'active' : '' }}" href="/absen">
  <div class="nav-link-icon"><i data-feather="map-pin"></i></div>
  Presensi
</a>

<!-- Tiket -->
<a class="nav-link {{ request()->is('tiket') ? 'active' : '' }}" href="/tiket">
  <div class="nav-link-icon"><i data-feather="file"></i></div>
  Tiket
</a>

@endif