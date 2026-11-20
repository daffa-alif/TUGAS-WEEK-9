@extends('layouts.app')

@section('title', 'Daftar Ticket Categories')

@section('content')
    <h2>Daftar Kategori Tiket (Ticket Categories - Alias)</h2>

    <p>
        <a href="{{ route('ticket-categories.create') }}">Tambah Ticket Category Baru</a>
    </p>

    <form method="GET" action="{{ route('ticket-categories.index') }}">
        <label for="filter_event_id">Filter berdasarkan ID Event:</label>
        <input type="number" id="filter_event_id" name="event_id" value="{{ request('event_id') }}" placeholder="ID Event">
        <button type="submit">Filter</button>
        @if(request('event_id'))
            <a href="{{ route('ticket-categories.index') }}">Reset</a>
        @endif
    </form>
    <br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event</th>
                <th>Nama Kategori (Tier Name)</th>
                <th>Harga</th>
                <th>Kuota</th>
                <th>Sisa Kursi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $items = $ticketCategories ?? $ticketTiers ?? $categories; @endphp
            @forelse ($items as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->event->title ?? ('Event #' . $category->event_id) }}</td>
                    <td>{{ $category->tier_name }}</td>
                    <td>Rp {{ number_format($category->price, 0, ',', '.') }}</td>
                    <td>{{ $category->quota }}</td>
                    <td>{{ $category->available_seats }}</td>
                    <td>
                        <a href="{{ route('ticket-categories.edit', $category->id) }}">Edit</a>

                        <form action="{{ route('ticket-categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori tiket ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data ticket category.</td>
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
