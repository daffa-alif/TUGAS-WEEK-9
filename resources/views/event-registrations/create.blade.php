@extends('layouts.app')

@section('title', 'Tambah Registrasi Event')

@section('content')
    <h2>Tambah Registrasi Event Baru</h2>

    <p><a href="{{ route('event-registrations.index') }}">&larr; Kembali ke Daftar Registrasi</a></p>

    <form action="{{ route('event-registrations.store') }}" method="POST">
        @csrf

        <div>
            <label for="event_id">Event:</label><br>
            @if(isset($events) && count($events) > 0)
                <select id="event_id" name="event_id" required>
                    <option value="">-- Pilih Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} (ID: {{ $event->id }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="event_id" name="event_id" value="{{ old('event_id') }}" required placeholder="ID Event">
            @endif
            @error('event_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="ticket_tier_id">Kategori Tiket (Ticket Tier):</label><br>
            @if(isset($ticketTiers) && count($ticketTiers) > 0)
                <select id="ticket_tier_id" name="ticket_tier_id" required>
                    <option value="">-- Pilih Kategori Tiket --</option>
                    @foreach($ticketTiers as $tier)
                        <option value="{{ $tier->id }}" {{ old('ticket_tier_id') == $tier->id ? 'selected' : '' }}>
                            {{ $tier->tier_name }} - Rp {{ number_format($tier->price, 0, ',', '.') }} (Event ID: {{ $tier->event_id }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="ticket_tier_id" name="ticket_tier_id" value="{{ old('ticket_tier_id') }}" required placeholder="ID Ticket Tier">
            @endif
            @error('ticket_tier_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="attendee_id">Peserta (Attendee):</label><br>
            @if(isset($attendees) && count($attendees) > 0)
                <select id="attendee_id" name="attendee_id" required>
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($attendees as $att)
                        <option value="{{ $att->id }}" {{ old('attendee_id') == $att->id ? 'selected' : '' }}>
                            {{ $att->full_name }} ({{ $att->email }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="attendee_id" name="attendee_id" value="{{ old('attendee_id') }}" required placeholder="ID Peserta">
            @endif
            @error('attendee_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="registration_code">Kode Registrasi:</label><br>
            <input type="text" id="registration_code" name="registration_code" maxlength="50" value="{{ old('registration_code', 'REG-' . strtoupper(Str::random(8))) }}" required>
            @error('registration_code')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="qr_code_hash">QR Code Hash:</label><br>
            <input type="text" id="qr_code_hash" name="qr_code_hash" maxlength="255" value="{{ old('qr_code_hash', md5(uniqid(mt_rand(), true))) }}" required>
            @error('qr_code_hash')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="payment_status">Status Pembayaran:</label><br>
            <select id="payment_status" name="payment_status">
                <option value="Pending" {{ old('payment_status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Cancelled" {{ old('payment_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('payment_status')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="attendance_status">Status Kehadiran:</label><br>
            <select id="attendance_status" name="attendance_status">
                <option value="Belum Hadir" {{ old('attendance_status', 'Belum Hadir') == 'Belum Hadir' ? 'selected' : '' }}>Belum Hadir</option>
                <option value="Hadir" {{ old('attendance_status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
            </select>
            @error('attendance_status')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Simpan Registrasi</button>
            <a href="{{ route('event-registrations.index') }}">Batal</a>
        </div>
    </form>
@endsection
