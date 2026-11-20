@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
    <h2>Edit Event: {{ $event->title }}</h2>

    <p><a href="{{ route('events.index') }}">&larr; Kembali ke Daftar Event</a></p>

    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="event_code">Kode Event:</label><br>
            <input type="text" id="event_code" name="event_code" maxlength="20" value="{{ old('event_code', $event->event_code) }}" required>
            @error('event_code')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="title">Judul Event:</label><br>
            <input type="text" id="title" name="title" maxlength="255" value="{{ old('title', $event->title) }}" required>
            @error('title')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="category">Kategori:</label><br>
            <select id="category" name="category" required>
                <option value="Teknologi" {{ old('category', $event->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                <option value="Bisnis" {{ old('category', $event->category) == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
            </select>
            @error('category')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="description">Deskripsi:</label><br>
            <textarea id="description" name="description" rows="5" cols="50" required>{{ old('description', $event->description) }}</textarea>
            @error('description')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="session_duration">Durasi Sesi (Menit):</label><br>
            <input type="number" id="session_duration" name="session_duration" min="1" max="65535" value="{{ old('session_duration', $event->session_duration) }}" required>
            @error('session_duration')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="total_sessions">Total Sesi:</label><br>
            <input type="number" id="total_sessions" name="total_sessions" min="1" max="255" value="{{ old('total_sessions', $event->total_sessions) }}" required>
            @error('total_sessions')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="status">Status:</label><br>
            <select id="status" name="status">
                <option value="Draft" {{ old('status', $event->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Published" {{ old('status', $event->status) == 'Published' ? 'selected' : '' }}>Published</option>
                <option value="Archived" {{ old('status', $event->status) == 'Archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Perbarui Event</button>
            <a href="{{ route('events.index') }}">Batal</a>
        </div>
    </form>
@endsection
