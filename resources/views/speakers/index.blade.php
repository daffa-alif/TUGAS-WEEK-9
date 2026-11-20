@extends('layouts.app')

@section('title', 'Daftar Speaker')

@section('content')
    <h2>Daftar Pembicara (Speakers)</h2>

    <p>
        <a href="{{ route('speakers.create') }}">Tambah Speaker Baru</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Keahlian (Expertise)</th>
                <th>Institusi</th>
                <th>Bio</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($speakers as $speaker)
                <tr>
                    <td>{{ $speaker->id }}</td>
                    <td>{{ $speaker->name }}</td>
                    <td>{{ $speaker->email }}</td>
                    <td>{{ $speaker->expertise }}</td>
                    <td>{{ $speaker->institution }}</td>
                    <td>{{ Str::limit($speaker->bio ?? '-', 50) }}</td>
                    <td>
                        <a href="{{ route('speakers.edit', $speaker->id) }}">Edit</a>

                        <form action="{{ route('speakers.destroy', $speaker->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus speaker ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data speaker.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($speakers, 'links'))
        <div>
            {{ $speakers->links() }}
        </div>
    @endif
@endsection
