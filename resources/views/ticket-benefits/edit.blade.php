@extends('layouts.app')

@section('title', 'Edit Ticket Benefit')

@section('content')
    @php
        $item = $ticketBenefit ?? $benefit;
    @endphp

    <h2>Edit Benefit Tiket #{{ $item->id }}</h2>

    <p><a href="{{ route('ticket-benefits.index') }}">&larr; Kembali ke Daftar Benefit</a></p>

    <form action="{{ route('ticket-benefits.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="ticket_tier_id">Kategori Tiket (Ticket Tier):</label><br>
            @if(isset($ticketTiers) && count($ticketTiers) > 0)
                <select id="ticket_tier_id" name="ticket_tier_id" required>
                    @foreach($ticketTiers as $tier)
                        <option value="{{ $tier->id }}" {{ old('ticket_tier_id', $item->ticket_tier_id) == $tier->id ? 'selected' : '' }}>
                            {{ $tier->tier_name }} (Event: {{ $tier->event->title ?? $tier->event_id }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="ticket_tier_id" name="ticket_tier_id" value="{{ old('ticket_tier_id', $item->ticket_tier_id) }}" required placeholder="ID Ticket Tier">
            @endif
            @error('ticket_tier_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="benefit">Nama / Deskripsi Benefit:</label><br>
            <input type="text" id="benefit" name="benefit" maxlength="255" value="{{ old('benefit', $item->benefit) }}" required>
            @error('benefit')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Perbarui Benefit</button>
            <a href="{{ route('ticket-benefits.index') }}">Batal</a>
        </div>
    </form>
@endsection
