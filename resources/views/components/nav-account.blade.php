<nav class="nav nav-borders">
  <a class="nav-link {{ (request()->segment(2) == 'profile') ? 'active' : '' }} ms-0" href="/account/profile">Profil</a>
  <a class="nav-link {{ (request()->segment(2) == 'information') ? 'active' : '' }} ms-0" href="/account/information">Gaji</a>
  <a class="nav-link {{ (request()->segment(2) == 'pengajuan') ? 'active' : '' }} ms-0" href="/account/pengajuan">Pengajuan</a>
</nav>