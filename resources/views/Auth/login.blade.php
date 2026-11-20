@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h2>Masuk ke Akun</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div>
            <label for="email">Alamat Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            @error('password')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                Ingat Saya
            </label>
        </div>
        <br>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>

    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
@endsection
