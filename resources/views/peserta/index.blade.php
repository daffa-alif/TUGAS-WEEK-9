@extends('layouts.app')

@section('title', 'Daftar Peserta (Compatibility Alias)')

@section('content')
    <h2>Daftar Peserta (Alias: peserta)</h2>

    <p>
        <a href="{{ route('peserta.create') }}">Tambah Peserta Baru</a>
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
            @php $items = $pesertaList ?? $peserta ?? $attendees; @endphp
            @forelse ($items as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->full_name }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->phone ?? '-' }}</td>
                    <td>{{ $p->institution ?? '-' }}</td>
                    <td>
                        <a href="{{ route('peserta.edit', $p->id) }}">Edit</a>

                        <form action="{{ route('peserta.destroy', $p->id) }}" method="POST" style="display:inline;">
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

    @if(isset($items) && method_exists($items, 'links'))
        <div>
            {{ $items->links() }}
        </div>
    @endif
@endsection
