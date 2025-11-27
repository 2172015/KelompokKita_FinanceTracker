<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #1b1d23;
            color: #fff;
        }
        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #111317;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px 15px;
        }
        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: #2a2d33;
            color: #fff;
        }
        .content {
            margin-left: 260px;
            padding: 30px;
        }
        .card-dark {
            background-color: #2a2d33;
            border: none;
            border-radius: 10px;
        }
        table {
            color: #fff;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <h4 class="text-white mb-4">Admin Panel</h4>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('events.index') }}" class="{{ request()->is('admin/events*') ? 'active' : '' }}">Events</a>
        <a href="{{ route('sessions.index') }}" class="{{ request()->is('admin/sessions*') ? 'active' : '' }}">Sessions</a>
        <a href="{{ route('registrations.index') }}" class="{{ request()->is('admin/registrations*') ? 'active' : '' }}">Registrations</a>
        <a href="{{ route('attendances.index') }}" class="{{ request()->is('admin/attendances*') ? 'active' : '' }}">Attendance</a>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <h2 class="mb-4">@yield('title')</h2>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
