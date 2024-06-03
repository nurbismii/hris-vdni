@if(strtolower(Auth::user()->job->permission_role ?? '') == 'admin divisi')
<div class="sidenav-menu-heading">Main menu</div>

<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
  <div class="nav-link-icon"><i data-feather="calendar"></i></div>
  Pengajuan karyawan
  <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ (request()->segment(1) == 'pengajuan-karyawan' || request()->segment(1) == 'roster' || request()->segment(3) == 'all-in') ? 'show' : '' }}" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
  <nav class="sidenav-menu-nested nav">
    <a class="nav-link {{ (request()->segment(1) == 'pengajuan-karyawan') ? 'active' : '' }}" href="/admin/cuti/">Cuti dan izin</a>
    <a class="nav-link {{ (request()->segment(3) == 'permohonan' && request()->segment(2) == 'roster') ? 'active' : '' }}" href="/admin/roster/permohonan">Cuti roster</a>
  </nav>
</div>
<a class="nav-link {{ (request()->segment(3) == '' && request()->segment(2) == 'roster') ? 'active' : '' }}" href="/admin/roster/">
  <div class="nav-link-icon"><i data-feather="bell"></i></div>
  Pengingat
</a>
@endif