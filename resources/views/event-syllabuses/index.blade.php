@extends('layouts.app')

@section('title', 'Daftar Event Syllabuses')

@section('content')
    <h2>Daftar Silabus Event</h2>

    <p>
        <a href="{{ route('event-syllabuses.create') }}">Tambah Silabus Baru</a>
    </p>

    <form method="GET" action="{{ route('event-syllabuses.index') }}">
        <label for="filter_event_id">Filter berdasarkan ID Event:</label>
        <input type="number" id="filter_event_id" name="event_id" value="{{ request('event_id') }}" placeholder="ID Event">
        <button type="submit">Filter</button>
        @if(request('event_id'))
            <a href="{{ route('event-syllabuses.index') }}">Reset</a>
        @endif
    </form>
    <br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event</th>
                <th>Modul Ke-</th>
                <th>Judul Modul</th>
                <th>Durasi (Menit)</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($syllabuses ?? $eventSyllabuses as $syllabus)
                <tr>
                    <td>{{ $syllabus->id }}</td>
                    <td>{{ $syllabus->event->title ?? ('Event #' . $syllabus->event_id) }}</td>
                    <td>{{ $syllabus->module_number }}</td>
                    <td>{{ $syllabus->title }}</td>
                    <td>{{ $syllabus->duration }}</td>
                    <td>{{ $syllabus->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('event-syllabuses.edit', $syllabus->id) }}">Edit</a>

                        <form action="{{ route('event-syllabuses.destroy', $syllabus->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus silabus ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data silabus.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @php $pagination = $syllabuses ?? $eventSyllabuses ?? null; @endphp
    @if($pagination && method_exists($pagination, 'links'))
        <div>
            {{ $pagination->appends(request()->query())->links() }}
        </div>
    @endif
@endsection
