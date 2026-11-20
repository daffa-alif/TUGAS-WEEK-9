@extends('layouts.app')

@section('title', 'Edit Peserta (Alias)')

@section('content')
    @php
        $item = $peserta ?? $attendee;
    @endphp

    <h2>Edit Peserta: {{ $item->full_name }}</h2>

    <p><a href="{{ route('peserta.index') }}">&larr; Kembali ke Daftar Peserta</a></p>

    <form action="{{ route('peserta.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="full_name">Nama Lengkap:</label><br>
            <input type="text" id="full_name" name="full_name" maxlength="150" value="{{ old('full_name', $item->full_name) }}" required>
            @error('full_name')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="email">Alamat Email:</label><br>
            <input type="email" id="email" name="email" maxlength="150" value="{{ old('email', $item->email) }}" required>
            @error('email')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="phone">Nomor Telepon (Opsional):</label><br>
            <input type="text" id="phone" name="phone" maxlength="25" value="{{ old('phone', $item->phone) }}">
            @error('phone')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="institution">Institusi / Instansi (Opsional):</label><br>
            <input type="text" id="institution" name="institution" maxlength="150" value="{{ old('institution', $item->institution) }}">
            @error('institution')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Perbarui Peserta</button>
            <a href="{{ route('peserta.index') }}">Batal</a>
        </div>
    </form>
@endsection
