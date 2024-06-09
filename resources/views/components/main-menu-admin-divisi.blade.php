@if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator div')
<div class="sidenav-menu-heading">Main menu</div>
<a class="nav-link {{ (request()->segment(3) == '' && request()->segment(2) == 'pengingat') ? 'active' : '' }}" href="/admin/pengingat/">
  <div class="nav-link-icon"><i data-feather="bell"></i></div>
  Pengingat
</a>

<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaCuti" aria-expanded="false" aria-controls="collapseKelolaCuti">
  <div class="nav-link-icon"><i data-feather="calendar"></i></div>
  Kelola Cuti
  <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ (request()->segment(1) == 'pengajuan-karyawan' || request()->segment(1) == 'roster' || request()->segment(3) == 'all-in') ? 'show' : '' }}" id="collapseKelolaCuti" data-bs-parent="#accordionSidenav">
  <nav class="sidenav-menu-nested nav">
    <a class="nav-link {{ (request()->segment(1) == 'admin' && request()->segment(2) == 'cuti') ? 'active' : '' }}" href="/admin/cuti/">Kelola Cuti & Izin</a>
    <a class="nav-link {{ (request()->segment(1) == 'admin' && request()->segment(2) == 'roster') ? 'active' : '' }}" href="/admin/permohonan">Kelola Cuti Roster</a>
  </nav>
</div>

<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKelolaLembur" aria-expanded="false" aria-controls="collapseKelolaLembur">
  <div class="nav-link-icon"><i data-feather="user-plus"></i></div>
  Kelola Lembur
  <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ (request()->segment(1) == 'admin' || request()->segment(2) == 'lembur') ? 'show' : '' }}" id="collapseKelolaLembur" data-bs-parent="#accordionSidenav">
  <nav class="sidenav-menu-nested nav">
    <a class="nav-link {{ (request()->segment(2) == 'lembur' && request()->segment(3) == '') ? 'active' : '' }}" href="/admin/lembur/">Data SPL</a>
    <a class="nav-link {{ (request()->segment(2) == 'lembur' && request()->segment(3) == 'create') ? 'active' : '' }}" href="/admin/lembur/create">Buat SPL</a>
  </nav>
</div>
@endif