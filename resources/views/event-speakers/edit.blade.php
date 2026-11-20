@extends('layouts.app')

@section('title', 'Edit Event Speaker')

@section('content')
    @php
        $item = $eventSpeaker ?? $speakerRelation;
    @endphp

    <h2>Edit Relasi Event Speaker #{{ $item->id }}</h2>

    <p><a href="{{ route('event-speakers.index') }}">&larr; Kembali ke Daftar Event Speakers</a></p>

    <form action="{{ route('event-speakers.update', $item->id) }}" method="POST">
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
                <input type="number" id="event_id" name="event_id" value="{{ old('event_id', $item->event_id) }}" required placeholder="ID Event">
            @endif
            @error('event_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="speaker_id">Speaker:</label><br>
            @if(isset($speakers) && count($speakers) > 0)
                <select id="speaker_id" name="speaker_id" required>
                    @foreach($speakers as $speaker)
                        <option value="{{ $speaker->id }}" {{ old('speaker_id', $item->speaker_id) == $speaker->id ? 'selected' : '' }}>
                            {{ $speaker->name }} ({{ $speaker->institution }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="speaker_id" name="speaker_id" value="{{ old('speaker_id', $item->speaker_id) }}" required placeholder="ID Speaker">
            @endif
            @error('speaker_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="syllabus_id">Silabus Terkait (Opsional):</label><br>
            @if(isset($syllabuses) && count($syllabuses) > 0)
                <select id="syllabus_id" name="syllabus_id">
                    <option value="">-- Tidak Terkait Silabus Spesifik --</option>
                    @foreach($syllabuses as $syl)
                        <option value="{{ $syl->id }}" {{ old('syllabus_id', $item->syllabus_id) == $syl->id ? 'selected' : '' }}>
                            Modul {{ $syl->module_number }}: {{ $syl->title }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="syllabus_id" name="syllabus_id" value="{{ old('syllabus_id', $item->syllabus_id) }}" placeholder="ID Silabus (Opsional)">
            @endif
            @error('syllabus_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="role_topic">Peran / Topik (Opsional):</label><br>
            <input type="text" id="role_topic" name="role_topic" maxlength="150" value="{{ old('role_topic', $item->role_topic) }}">
            @error('role_topic')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Perbarui Event Speaker</button>
            <a href="{{ route('event-speakers.index') }}">Batal</a>
        </div>
    </form>
@endsection
