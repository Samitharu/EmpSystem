<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">HR Partner</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      @can('view home')
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/home">Home</a>
        </li>
        @endcan
        @role(['admin', 'HR manager'])
        <li class="nav-item">
          <a class="nav-link" href="/employee">Employee</a>
        </li>
        @endrole
        @role(['admin', 'HR manager'])
        <li class="nav-item">
          <a class="nav-link" href="/reports">Reports</a>
        </li>
        @endrole
        @role(['admin', 'HR manager','employee'])
        <li class="nav-item">
          <a class="nav-link" href="/setting">Setting</a>
        </li>
        @endrole
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
