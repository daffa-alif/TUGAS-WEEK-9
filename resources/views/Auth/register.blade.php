@extends('layouts.index')

@section('title', 'Registrasi')

@section('content')
    <h2>Halaman Pendaftaran</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <p>
            <label for="name">Nama Lengkap:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            @error('password') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="password_confirmation">Konfirmasi Password:</label><br>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </p>

        <p>
            <button type="submit">Daftar</button>
        </p>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
@endsection