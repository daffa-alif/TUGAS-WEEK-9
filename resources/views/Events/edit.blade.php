@extends('layouts.index')

@section('title', 'Edit Event')

@section('content')
    <h2>Edit Event: {{ $event->event_code }}</h2>

    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label for="event_code">Kode Event:</label><br>
            <input type="text" id="event_code" name="event_code" value="{{ old('event_code', $event->event_code) }}" required>
            @error('event_code') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="title">Judul Event:</label><br>
            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required>
            @error('title') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="category">Kategori:</label><br>
            <select id="category" name="category" required>
                <option value="Teknologi" {{ old('category', $event->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                <option value="Bisnis" {{ old('category', $event->category) == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
            </select>
            @error('category') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="description">Deskripsi:</label><br>
            <textarea id="description" name="description" rows="4" required>{{ old('description', $event->description) }}</textarea>
            @error('description') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="session_duration">Durasi Sesi (Menit):</label><br>
            <input type="number" id="session_duration" name="session_duration" value="{{ old('session_duration', $event->session_duration) }}" min="1" required>
            @error('session_duration') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="total_sessions">Total Sesi:</label><br>
            <input type="number" id="total_sessions" name="total_sessions" value="{{ old('total_sessions', $event->total_sessions) }}" min="1" required>
            @error('total_sessions') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <label for="status">Status:</label><br>
            <select id="status" name="status" required>
                <option value="Draft" {{ old('status', $event->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Published" {{ old('status', $event->status) == 'Published' ? 'selected' : '' }}>Published</option>
                <option value="Archived" {{ old('status', $event->status) == 'Archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status') <br><small style="color:red;">{{ $message }}</small> @enderror
        </p>

        <p>
            <button type="submit">Update Event</button>
            <a href="{{ route('events.index') }}">Batal</a>
        </p>
    </form>
@endsection