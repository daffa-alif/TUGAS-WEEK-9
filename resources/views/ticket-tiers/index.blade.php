@extends('layouts.app')

@section('title', 'Daftar Ticket Tiers')

@section('content')
    <h2>Daftar Kategori Tiket (Ticket Tiers)</h2>

    <p>
        <a href="{{ route('ticket-tiers.create') }}">Tambah Ticket Tier Baru</a>
    </p>

    <form method="GET" action="{{ route('ticket-tiers.index') }}">
        <label for="filter_event_id">Filter berdasarkan ID Event:</label>
        <input type="number" id="filter_event_id" name="event_id" value="{{ request('event_id') }}" placeholder="ID Event">
        <button type="submit">Filter</button>
        @if(request('event_id'))
            <a href="{{ route('ticket-tiers.index') }}">Reset</a>
        @endif
    </form>
    <br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event</th>
                <th>Nama Tier</th>
                <th>Harga</th>
                <th>Kuota</th>
                <th>Sisa Kursi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $items = $ticketTiers ?? $tiers; @endphp
            @forelse ($items as $tier)
                <tr>
                    <td>{{ $tier->id }}</td>
                    <td>{{ $tier->event->title ?? ('Event #' . $tier->event_id) }}</td>
                    <td>{{ $tier->tier_name }}</td>
                    <td>Rp {{ number_format($tier->price, 0, ',', '.') }}</td>
                    <td>{{ $tier->quota }}</td>
                    <td>{{ $tier->available_seats }}</td>
                    <td>
                        <a href="{{ route('ticket-tiers.edit', $tier->id) }}">Edit</a>

                        <form action="{{ route('ticket-tiers.destroy', $tier->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori tiket ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data ticket tier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(isset($items) && method_exists($items, 'links'))
        <div>
            {{ $items->appends(request()->query())->links() }}
        </div>
    @endif
@endsection
