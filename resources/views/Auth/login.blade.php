@extends('layouts.index')

@section('title', 'Login')

@section('content')
    <h2>Halaman Login</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            @error('password') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Ingat Saya</label>
        </p>

        <p>
            <button type="submit">Login</button>
        </p>
    </form>

    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
@endsection