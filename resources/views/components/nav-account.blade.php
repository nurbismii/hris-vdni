<nav class="nav nav-borders">
  <a class="nav-link {{ (request()->segment(2) == 'profile') ? 'active' : '' }} ms-0" href="/account/profile">Profile</a>
  <a class="nav-link {{ (request()->segment(2) == 'billing') ? 'active' : '' }} ms-0" href="/account/billing">Billing</a>
</nav>