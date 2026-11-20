@extends('layouts.app')

@section('title', 'Daftar Event')

@section('content')
    <h2>Daftar Event</h2>

    <p>
        <a href="{{ route('events.create') }}">Tambah Event Baru</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Event</th>
                <th>Judul Event</th>
                <th>Kategori</th>
                <th>Durasi Sesi (Menit)</th>
                <th>Total Sesi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>{{ $event->event_code }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->category }}</td>
                    <td>{{ $event->session_duration }}</td>
                    <td>{{ $event->total_sessions }}</td>
                    <td>{{ $event->status }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}">Edit</a>

                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus/mengarsipkan event ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data event.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($events, 'links'))
        <div>
            {{ $events->links() }}
        </div>
    @endif
@endsection
