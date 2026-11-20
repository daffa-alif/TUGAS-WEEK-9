<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketTier;
use Illuminate\Http\Request;

/**
 * Compatibility controller for the original TicketCategory naming.
 * Uses the consolidated TicketTier table/model through inheritance or redirection to views.
 */
class TicketCategoryController extends TicketTierController
{
    public function index(Request $request)
    {
        $query = TicketTier::with('event', 'ticketBenefits');

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->integer('event_id'));
        }

        $ticketCategories = $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($ticketCategories);
        }

        return view('ticket-categories.index', compact('ticketCategories'));
    }

    public function create()
    {
        $events = Event::all();
        return view('ticket-categories.create', compact('events'));
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

        return redirect()->route('ticket-categories.index')->with('success', 'Kategori tiket berhasil ditambahkan.');
    }

    public function show(Request $request, TicketTier $ticketCategory)
    {
        $loaded = $ticketCategory->load(['event', 'registrations.attendee', 'ticketBenefits']);

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        $events = Event::all();
        return view('ticket-categories.edit', ['ticketCategory' => $loaded, 'events' => $events]);
    }

    public function edit(TicketTier $ticketCategory)
    {
        $events = Event::all();
        return view('ticket-categories.edit', compact('ticketCategory', 'events'));
    }

    public function update(Request $request, TicketTier $ticketCategory)
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

        $quota = $data['quota'] ?? $ticketCategory->quota;
        $available = $data['available_seats'] ?? $ticketCategory->available_seats;
        if ($available > $quota) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'available_seats tidak boleh melebihi quota.'], 422);
            }
            return back()->withErrors(['available_seats' => 'Sisa kursi tidak boleh melebihi kuota total.'])->withInput();
        }

        $ticketCategory->update($data);

        if ($request->wantsJson()) {
            return response()->json($ticketCategory->fresh()->load(['event', 'ticketBenefits']));
        }

        return redirect()->route('ticket-categories.index')->with('success', 'Kategori tiket berhasil diperbarui.');
    }

    public function destroy(Request $request, TicketTier $ticketCategory)
    {
        $ticketCategory->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Kategori tiket berhasil dihapus.']);
        }

        return redirect()->route('ticket-categories.index')->with('success', 'Kategori tiket berhasil dihapus.');
    }
}
