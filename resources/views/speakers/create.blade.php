@extends('layouts.app')

@section('title', 'Tambah Speaker')

@section('content')
    <h2>Tambah Speaker Baru</h2>

    <p><a href="{{ route('speakers.index') }}">&larr; Kembali ke Daftar Speaker</a></p>

    <form action="{{ route('speakers.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nama Lengkap:</label><br>
            <input type="text" id="name" name="name" maxlength="150" value="{{ old('name') }}" required>
            @error('name')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="email">Alamat Email:</label><br>
            <input type="email" id="email" name="email" maxlength="150" value="{{ old('email') }}" required>
            @error('email')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="expertise">Keahlian (Expertise):</label><br>
            <input type="text" id="expertise" name="expertise" maxlength="255" value="{{ old('expertise') }}" required>
            @error('expertise')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="institution">Institusi / Perusahaan:</label><br>
            <input type="text" id="institution" name="institution" maxlength="150" value="{{ old('institution') }}" required>
            @error('institution')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="bio">Biografi Singkat (Opsional):</label><br>
            <textarea id="bio" name="bio" rows="4" cols="50">{{ old('bio') }}</textarea>
            @error('bio')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Simpan Speaker</button>
            <a href="{{ route('speakers.index') }}">Batal</a>
        </div>
    </form>
@endsection
