@extends('layouts.app')

@section('title', 'Tambah Silabus Event')

@section('content')
    <h2>Tambah Silabus Event Baru</h2>

    <p><a href="{{ route('event-syllabuses.index') }}">&larr; Kembali ke Daftar Silabus</a></p>

    <form action="{{ route('event-syllabuses.store') }}" method="POST">
        @csrf

        <div>
            <label for="event_id">Event:</label><br>
            @if(isset($events) && count($events) > 0)
                <select id="event_id" name="event_id" required>
                    <option value="">-- Pilih Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} (ID: {{ $event->id }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="event_id" name="event_id" value="{{ old('event_id') }}" required placeholder="Masukkan ID Event">
            @endif
            @error('event_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="module_number">Nomor Modul:</label><br>
            <input type="number" id="module_number" name="module_number" min="1" max="255" value="{{ old('module_number', 1) }}" required>
            @error('module_number')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="title">Judul Modul:</label><br>
            <input type="text" id="title" name="title" maxlength="255" value="{{ old('title') }}" required>
            @error('title')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="duration">Durasi (Menit):</label><br>
            <input type="number" id="duration" name="duration" min="1" max="65535" value="{{ old('duration', 60) }}" required>
            @error('duration')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="description">Deskripsi (Opsional):</label><br>
            <textarea id="description" name="description" rows="4" cols="50">{{ old('description') }}</textarea>
            @error('description')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Simpan Silabus</button>
            <a href="{{ route('event-syllabuses.index') }}">Batal</a>
        </div>
    </form>
@endsection
