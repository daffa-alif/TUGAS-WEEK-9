@extends('layouts.app')

@section('title', 'Edit Ticket Category')

@section('content')
    @php
        $item = $ticketCategory ?? $ticketTier ?? $category;
    @endphp

    <h2>Edit Kategori Tiket: {{ $item->tier_name }}</h2>

    <p><a href="{{ route('ticket-categories.index') }}">&larr; Kembali ke Daftar Ticket Categories</a></p>

    <form action="{{ route('ticket-categories.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="event_id">Event:</label><br>
            @if(isset($events) && count($events) > 0)
                <select id="event_id" name="event_id" required>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id', $item->event_id) == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} (ID: {{ $event->id }})
                        </option>
                    @endforeach
                </select>
            @else
                <input type="number" id="event_id" name="event_id" value="{{ old('event_id', $item->event_id) }}" required placeholder="ID Event">
            @endif
            @error('event_id')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="tier_name">Nama Kategori Tiket (Tier Name):</label><br>
            <input type="text" id="tier_name" name="tier_name" maxlength="100" value="{{ old('tier_name', $item->tier_name) }}" required>
            @error('tier_name')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="price">Harga (IDR):</label><br>
            <input type="number" id="price" name="price" min="0" step="1000" value="{{ old('price', $item->price) }}" required>
            @error('price')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="quota">Kuota Total:</label><br>
            <input type="number" id="quota" name="quota" min="0" value="{{ old('quota', $item->quota) }}" required>
            @error('quota')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="available_seats">Sisa Kursi Tersedia:</label><br>
            <input type="number" id="available_seats" name="available_seats" min="0" value="{{ old('available_seats', $item->available_seats) }}" required>
            @error('available_seats')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Perbarui Ticket Category</button>
            <a href="{{ route('ticket-categories.index') }}">Batal</a>
        </div>
    </form>
@endsection
