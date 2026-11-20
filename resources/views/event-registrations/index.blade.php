@extends('layouts.app')

@section('title', 'Daftar Registrasi Event')

@section('content')
    <h2>Daftar Registrasi Event</h2>

    <p>
        <a href="{{ route('event-registrations.create') }}">Tambah Registrasi Baru</a>
    </p>

    <form method="GET" action="{{ route('event-registrations.index') }}">
        <label for="filter_payment">Status Pembayaran:</label>
        <select id="filter_payment" name="payment_status">
            <option value="">Semua</option>
            <option value="Pending" {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
            <option value="Cancelled" {{ request('payment_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <label for="filter_attendance">Status Kehadiran:</label>
        <select id="filter_attendance" name="attendance_status">
            <option value="">Semua</option>
            <option value="Belum Hadir" {{ request('attendance_status') == 'Belum Hadir' ? 'selected' : '' }}>Belum Hadir</option>
            <option value="Hadir" {{ request('attendance_status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
        </select>

        <button type="submit">Filter</button>
        @if(request()->hasAny(['payment_status', 'attendance_status', 'event_id']))
            <a href="{{ route('event-registrations.index') }}">Reset</a>
        @endif
    </form>
    <br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Registrasi</th>
                <th>Peserta</th>
                <th>Event</th>
                <th>Kategori Tiket</th>
                <th>Status Pembayaran</th>
                <th>Status Kehadiran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $items = $eventRegistrations ?? $registrations; @endphp
            @forelse ($items as $registration)
                <tr>
                    <td>{{ $registration->id }}</td>
                    <td>{{ $registration->registration_code }}</td>
                    <td>{{ $registration->attendee->full_name ?? ('Peserta #' . $registration->attendee_id) }}</td>
                    <td>{{ $registration->event->title ?? ('Event #' . $registration->event_id) }}</td>
                    <td>{{ $registration->ticketTier->tier_name ?? ('Tier #' . $registration->ticket_tier_id) }}</td>
                    <td>{{ $registration->payment_status }}</td>
                    <td>{{ $registration->attendance_status }}</td>
                    <td>
                        <a href="{{ route('event-registrations.edit', $registration->id) }}">Edit</a>

                        <form action="{{ route('event-registrations.destroy', $registration->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus registrasi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data registrasi event.</td>
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
