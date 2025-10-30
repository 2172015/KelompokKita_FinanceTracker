<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Events</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('sessions.index') }}">Sessions</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('registrations.index') }}">Registrations</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('attendance.index') }}">Attendance</a></li>
      </ul>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
      </form>
    </div>
  </div>
</nav>
