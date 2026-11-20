<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketTier;
use Illuminate\Http\Request;

class TicketTierController extends Controller
{
    public function index(Request $request)
    {
        $query = TicketTier::with('event', 'ticketBenefits');

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->integer('event_id'));
        }

        $ticketTiers = $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($ticketTiers);
        }

        return view('ticket-tiers.index', compact('ticketTiers'));
    }

    public function create()
    {
        $events = Event::all();
        return view('ticket-tiers.create', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'tier_name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'quota' => ['required', 'integer', 'min:0'],
            'available_seats' => ['required', 'integer', 'min:0', 'lte:quota'],
            'benefits' => ['nullable', 'array'],
            'benefits.*' => ['string'],
        ]);

        $ticketTier = TicketTier::create($data);

        if ($request->wantsJson()) {
            return response()->json($ticketTier->load(['event', 'ticketBenefits']), 201);
        }

        return redirect()->route('ticket-tiers.index')->with('success', 'Kategori tiket berhasil ditambahkan.');
    }

    public function show(Request $request, TicketTier $ticketTier)
    {
        $loaded = $ticketTier->load(['event', 'registrations.attendee', 'ticketBenefits']);

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        $events = Event::all();
        return view('ticket-tiers.edit', ['ticketTier' => $loaded, 'events' => $events]);
    }

    public function edit(TicketTier $ticketTier)
    {
        $events = Event::all();
        return view('ticket-tiers.edit', compact('ticketTier', 'events'));
    }

    public function update(Request $request, TicketTier $ticketTier)
    {
        $data = $request->validate([
            'event_id' => ['sometimes', 'required', 'integer', 'exists:events,id'],
            'tier_name' => ['sometimes', 'required', 'string', 'max:100'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'quota' => ['sometimes', 'required', 'integer', 'min:0'],
            'available_seats' => ['sometimes', 'required', 'integer', 'min:0'],
            'benefits' => ['sometimes', 'nullable', 'array'],
            'benefits.*' => ['string'],
        ]);

        $quota = $data['quota'] ?? $ticketTier->quota;
        $available = $data['available_seats'] ?? $ticketTier->available_seats;
        if ($available > $quota) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'available_seats tidak boleh melebihi quota.'], 422);
            }
            return back()->withErrors(['available_seats' => 'Sisa kursi tidak boleh melebihi kuota total.'])->withInput();
        }

        $ticketTier->update($data);

        if ($request->wantsJson()) {
            return response()->json($ticketTier->fresh()->load(['event', 'ticketBenefits']));
        }

        return redirect()->route('ticket-tiers.index')->with('success', 'Kategori tiket berhasil diperbarui.');
    }

    public function destroy(Request $request, TicketTier $ticketTier)
    {
        $ticketTier->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Kategori tiket berhasil dihapus.']);
        }

        return redirect()->route('ticket-tiers.index')->with('success', 'Kategori tiket berhasil dihapus.');
    }
}
