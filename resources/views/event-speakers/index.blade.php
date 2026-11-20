@extends('layouts.app')

@section('title', 'Daftar Event Speakers')

@section('content')
    <h2>Daftar Pembicara Event (Event Speakers)</h2>

    <p>
        <a href="{{ route('event-speakers.create') }}">Tambah Hubungan Event Speaker Baru</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event</th>
                <th>Speaker</th>
                <th>Silabus / Modul Terkait</th>
                <th>Peran / Topik (Role Topic)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $items = $eventSpeakers ?? $speakersList ?? $event_speakers; @endphp
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->event->title ?? ('Event #' . $item->event_id) }}</td>
                    <td>{{ $item->speaker->name ?? ('Speaker #' . $item->speaker_id) }}</td>
                    <td>{{ $item->syllabus->title ?? ($item->syllabus_id ? 'Silabus #' . $item->syllabus_id : '-') }}</td>
                    <td>{{ $item->role_topic ?? '-' }}</td>
                    <td>
                        <a href="{{ route('event-speakers.edit', $item->id) }}">Edit</a>

                        <form action="{{ route('event-speakers.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus relasi event speaker ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data relasi event speaker.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(isset($items) && method_exists($items, 'links'))
        <div>
            {{ $items->links() }}
        </div>
    @endif
@endsection
