@extends('layouts.app')

@section('title', 'Daftar Ticket Benefits')

@section('content')
    <h2>Daftar Benefit Tiket</h2>

    <p>
        <a href="{{ route('ticket-benefits.create') }}">Tambah Benefit Tiket Baru</a>
    </p>

    <form method="GET" action="{{ route('ticket-benefits.index') }}">
        <label for="filter_tier_id">Filter berdasarkan ID Ticket Tier:</label>
        <input type="number" id="filter_tier_id" name="ticket_tier_id" value="{{ request('ticket_tier_id') }}" placeholder="ID Ticket Tier">
        <button type="submit">Filter</button>
        @if(request('ticket_tier_id'))
            <a href="{{ route('ticket-benefits.index') }}">Reset</a>
        @endif
    </form>
    <br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori Tiket (Ticket Tier)</th>
                <th>Nama Benefit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $items = $ticketBenefits ?? $benefits; @endphp
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->ticketTier->tier_name ?? ('Tier #' . $item->ticket_tier_id) }}</td>
                    <td>{{ $item->benefit }}</td>
                    <td>
                        <a href="{{ route('ticket-benefits.edit', $item->id) }}">Edit</a>

                        <form action="{{ route('ticket-benefits.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus benefit tiket ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data benefit tiket.</td>
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
