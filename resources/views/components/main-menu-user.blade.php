@if(strtolower(Auth::user()->job->permission_role ?? '') == '')

<div class="sidenav-menu-heading">Main menu</div>

<a class="nav-link {{ (request()->segment(1) == 'karyawan' && request()->segment(2) == '') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
  <div class="nav-link-icon"><i data-feather="upload"></i></div>
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

<a class="nav-link {{ (request()->segment(2) == 'pengajuan' || request()->segment(2) == 'status-permohonan') ? '' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseStatusPengajuan" aria-expanded="false" aria-controls="collapseStatusPengajuan">
  <div class="nav-link-icon"><i data-feather="file-text"></i></div>
  Status pengajuan
  <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ (request()->segment(2) == 'status-permohonan' || request()->segment(2) == 'pengajuan') ? 'show' : '' }}" id="collapseStatusPengajuan" data-bs-parent="#accordionSidenav">
  <nav class="sidenav-menu-nested nav">
    <a class="nav-link {{ (request()->segment(2) == 'status-permohonan') ? 'active' : '' }}" href="/karyawan/status-permohonan">Cuti roster</a>
    <a class="nav-link {{ (request()->segment(2) == 'pengajuan') ? 'active' : '' }}" href="/account/pengajuan">Cuti tahunan dan izin</a>
  </nav>
</div>
<a class="nav-link {{ (request()->segment(2) == 'lembur') ? 'active' : '' }}" href="/karyawan/lembur">
  <div class="nav-link-icon"><i data-feather="file-text"></i></div>
  Lembur
</a>
<a class="nav-link {{ (request()->segment(1) == 'absen') ? 'active' : '' }}" href="/absen">
  <div class="nav-link-icon"><i data-feather="map-pin"></i></div>
  Presensi
</a>
<a class="nav-link {{ (request()->segment(1) == 'tiket') ? 'active' : '' }}" href="/tiket">
  <div class="nav-link-icon"><i data-feather="file"></i></div>
  Tiket
</a>
@endif