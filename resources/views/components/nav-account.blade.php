<nav class="nav nav-borders">
  <a class="nav-link {{ (request()->segment(2) == 'profile') ? 'active' : '' }} ms-0" href="/account/profile">Profil</a>
  <a class="nav-link {{ (request()->segment(2) == 'information') ? 'active' : '' }} ms-0" href="/account/slip-gaji">Slip gaji</a>
</nav>