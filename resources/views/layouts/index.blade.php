<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Event')</title>
</head>
<body>

    <header>
        <h1>Aplikasi Kelola Event</h1>
        <nav>
            <ul>
                @auth
                    <li><a href="{{ route('events.index') }}">Daftar Event</a></li>
                    <li><a href="{{ route('events.create') }}">Tambah Event</a></li>
                    <li>
                        <strong>Halo, {{ Auth::user()->name }} ({{ Auth::user()->role }})</strong>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <hr>

    <main>
        @if(session('success'))
            <p><strong>{{ session('success') }}</strong></p>
            <hr>
        @endif

        @yield('content')
    </main>

    <hr>

    <footer>
        <p>&copy; {{ date('Y') }} Manajemen Event</p>
    </footer>

</body>
</html>