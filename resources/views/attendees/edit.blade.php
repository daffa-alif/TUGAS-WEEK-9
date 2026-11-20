@extends('layouts.app')

@section('title', 'Edit Peserta')

@section('content')
    <h2>Edit Peserta: {{ $attendee->full_name }}</h2>

    <p><a href="{{ route('attendees.index') }}">&larr; Kembali ke Daftar Peserta</a></p>

    <form action="{{ route('attendees.update', $attendee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="full_name">Nama Lengkap:</label><br>
            <input type="text" id="full_name" name="full_name" maxlength="150" value="{{ old('full_name', $attendee->full_name) }}" required>
            @error('full_name')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="email">Alamat Email:</label><br>
            <input type="email" id="email" name="email" maxlength="150" value="{{ old('email', $attendee->email) }}" required>
            @error('email')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="phone">Nomor Telepon (Opsional):</label><br>
            <input type="text" id="phone" name="phone" maxlength="25" value="{{ old('phone', $attendee->phone) }}">
            @error('phone')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="institution">Institusi / Instansi (Opsional):</label><br>
            <input type="text" id="institution" name="institution" maxlength="150" value="{{ old('institution', $attendee->institution) }}">
            @error('institution')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Perbarui Peserta</button>
            <a href="{{ route('attendees.index') }}">Batal</a>
        </div>
    </form>
@endsection
