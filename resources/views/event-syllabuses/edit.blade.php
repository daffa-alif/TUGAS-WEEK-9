@extends('layouts.app')

@section('title', 'Edit Silabus Event')

@section('content')
    @php
        $item = $eventSyllabus ?? $syllabus;
    @endphp

    <h2>Edit Silabus: {{ $item->title }}</h2>

    <p><a href="{{ route('event-syllabuses.index') }}">&larr; Kembali ke Daftar Silabus</a></p>

    <form action="{{ route('event-syllabuses.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="event_id">Event:</label><br>
            @if(isset($events) && count($events) > 0)
                <select id="event_id" name="event_id" required>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id', $item->event_id) == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} (ID: {{ $event->id }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="event_id" name="event_id" value="{{ old('event_id', $item->event_id) }}" required placeholder="Masukkan ID Event">
            @endif
            @error('event_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="module_number">Nomor Modul:</label><br>
            <input type="number" id="module_number" name="module_number" min="1" max="255" value="{{ old('module_number', $item->module_number) }}" required>
            @error('module_number')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="title">Judul Modul:</label><br>
            <input type="text" id="title" name="title" maxlength="255" value="{{ old('title', $item->title) }}" required>
            @error('title')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="duration">Durasi (Menit):</label><br>
            <input type="number" id="duration" name="duration" min="1" max="65535" value="{{ old('duration', $item->duration) }}" required>
            @error('duration')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="description">Deskripsi (Opsional):</label><br>
            <textarea id="description" name="description" rows="4" cols="50">{{ old('description', $item->description) }}</textarea>
            @error('description')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Perbarui Silabus</button>
            <a href="{{ route('event-syllabuses.index') }}">Batal</a>
        </div>
    </form>
@endsection
