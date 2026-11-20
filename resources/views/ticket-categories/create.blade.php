@extends('layouts.app')

@section('title', 'Tambah Ticket Category')

@section('content')
    <h2>Tambah Kategori Tiket Baru (Ticket Category - Alias)</h2>

    <p><a href="{{ route('ticket-categories.index') }}">&larr; Kembali ke Daftar Ticket Categories</a></p>

    <form action="{{ route('ticket-categories.store') }}" method="POST">
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
            <label for="tier_name">Nama Kategori Tiket (Tier Name):</label><br>
            <input type="text" id="tier_name" name="tier_name" maxlength="100" value="{{ old('tier_name') }}" placeholder="Contoh: Early Bird, VIP, Regular" required>
            @error('tier_name')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="price">Harga (IDR):</label><br>
            <input type="number" id="price" name="price" min="0" step="1000" value="{{ old('price', 0) }}" required>
            @error('price')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="quota">Kuota Total:</label><br>
            <input type="number" id="quota" name="quota" min="0" value="{{ old('quota', 100) }}" required>
            @error('quota')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <label for="available_seats">Sisa Kursi Tersedia:</label><br>
            <input type="number" id="available_seats" name="available_seats" min="0" value="{{ old('available_seats', 100) }}" required>
            @error('available_seats')
                <br><small>{{ $message }}</small>
            @enderror
        </div>
        <br>

        <div>
            <button type="submit">Simpan Ticket Category</button>
            <a href="{{ route('ticket-categories.index') }}">Batal</a>
        </div>
    </form>
@endsection
