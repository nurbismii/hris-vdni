<nav class="nav nav-borders">
  <a class="nav-link {{ (request()->segment(2) == 'profile') ? 'active' : '' }} ms-0" href="/account/profile">Profile</a>
  <a class="nav-link {{ (request()->segment(2) == 'information') ? 'active' : '' }} ms-0" href="/account/information">Salary</a>
  <a class="nav-link {{ (request()->segment(2) == 'pengajuan') ? 'active' : '' }} ms-0" href="/account/pengajuan">Submission</a>
</nav>