<?php

namespace App\Http\Controllers;

use App\Models\TicketBenefit;
use App\Models\TicketTier;
use Illuminate\Http\Request;

class TicketBenefitController extends Controller
{
    public function index(Request $request)
    {
        $query = TicketBenefit::with('ticketTier.event');

        if ($request->filled('ticket_tier_id')) {
            $query->where('ticket_tier_id', $request->integer('ticket_tier_id'));
        }

        $ticketBenefits = $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($ticketBenefits);
        }

        return view('ticket-benefits.index', compact('ticketBenefits'));
    }

    public function create()
    {
        $ticketTiers = TicketTier::with('event')->get();
        return view('ticket-benefits.create', compact('ticketTiers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_tier_id' => ['required', 'integer', 'exists:ticket_tiers,id'],
            'benefit' => ['required', 'string', 'max:255'],
        ]);

        $benefit = TicketBenefit::create($data);

        if ($request->wantsJson()) {
            return response()->json($benefit->load('ticketTier'), 201);
        }

        return redirect()->route('ticket-benefits.index')->with('success', 'Benefit tiket berhasil ditambahkan.');
    }

    public function show(Request $request, TicketBenefit $ticketBenefit)
    {
        $loaded = $ticketBenefit->load('ticketTier');

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        $ticketTiers = TicketTier::with('event')->get();
        return view('ticket-benefits.edit', ['ticketBenefit' => $loaded, 'ticketTiers' => $ticketTiers]);
    }

    public function edit(TicketBenefit $ticketBenefit)
    {
        $ticketTiers = TicketTier::with('event')->get();
        return view('ticket-benefits.edit', compact('ticketBenefit', 'ticketTiers'));
    }

    public function update(Request $request, TicketBenefit $ticketBenefit)
    {
        $data = $request->validate([
            'ticket_tier_id' => ['sometimes', 'required', 'integer', 'exists:ticket_tiers,id'],
            'benefit' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $ticketBenefit->update($data);

        if ($request->wantsJson()) {
            return response()->json($ticketBenefit->fresh()->load('ticketTier'));
        }

        return redirect()->route('ticket-benefits.index')->with('success', 'Benefit tiket berhasil diperbarui.');
    }

    public function destroy(Request $request, TicketBenefit $ticketBenefit)
    {
        $ticketBenefit->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Benefit tiket berhasil dihapus.']);
        }

        return redirect()->route('ticket-benefits.index')->with('success', 'Benefit tiket berhasil dihapus.');
    }
}
