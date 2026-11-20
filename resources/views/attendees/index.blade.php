@extends('layouts.app')

@section('title', 'Daftar Peserta (Attendees)')

@section('content')
    <h2>Daftar Peserta (Attendees)</h2>

    <p>
        <a href="{{ route('attendees.create') }}">Tambah Peserta Baru</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Institusi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendees as $attendee)
                <tr>
                    <td>{{ $attendee->id }}</td>
                    <td>{{ $attendee->full_name }}</td>
                    <td>{{ $attendee->email }}</td>
                    <td>{{ $attendee->phone ?? '-' }}</td>
                    <td>{{ $attendee->institution ?? '-' }}</td>
                    <td>
                        <a href="{{ route('attendees.edit', $attendee->id) }}">Edit</a>

                        <form action="{{ route('attendees.destroy', $attendee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data peserta.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($attendees, 'links'))
        <div>
            {{ $attendees->links() }}
        </div>
    @endif
@endsection
