@extends('layouts.index')

@section('title', 'Daftar Event')

@section('content')
    <h2>Daftar Event</h2>

    <a href="{{ route('events.create') }}">+ Tambah Event Baru</a>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Durasi</th>
                <th>Total Sesi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->event_code }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->category }}</td>
                    <td>{{ $event->session_duration }} Menit</td>
                    <td>{{ $event->total_sessions }} Sesi</td>
                    <td>{{ $event->status }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}">Edit</a>
                        @if(auth()->user()->role === 'Admin')
                            |
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus event ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data event.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    {{ $events->links() }}
@endsection