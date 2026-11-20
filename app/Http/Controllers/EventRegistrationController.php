<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\TicketTier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = EventRegistration::with(['event', 'ticketTier', 'attendee']);

        foreach (['event_id', 'ticket_tier_id', 'attendee_id', 'payment_status', 'attendance_status'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        $eventRegistrations = $query->latest()->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($eventRegistrations);
        }

        return view('event-registrations.index', compact('eventRegistrations'));
    }

    public function create()
    {
        $events = Event::all();
        $ticketTiers = TicketTier::all();
        $attendees = Attendee::all();

        return view('event-registrations.create', compact('events', 'ticketTiers', 'attendees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'ticket_tier_id' => [
                'required', 'integer',
                Rule::exists('ticket_tiers', 'id')->where(fn ($query) => $query->where('event_id', $request->input('event_id'))),
            ],
            'attendee_id' => ['required', 'integer', 'exists:attendees,id'],
            'registration_code' => ['required', 'string', 'max:50', 'unique:event_registrations,registration_code'],
            'qr_code_hash' => ['required', 'string', 'max:255'],
            'payment_status' => ['sometimes', Rule::in(['Pending', 'Paid', 'Cancelled'])],
            'attendance_status' => ['sometimes', Rule::in(['Belum Hadir', 'Hadir'])],
        ]);

        $registration = EventRegistration::create($data);

        if ($request->wantsJson()) {
            return response()->json($registration->load(['event', 'ticketTier', 'attendee']), 201);
        }

        return redirect()->route('event-registrations.index')->with('success', 'Registrasi berhasil ditambahkan.');
    }

    public function show(Request $request, EventRegistration $eventRegistration)
    {
        $loaded = $eventRegistration->load(['event', 'ticketTier', 'attendee']);

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        $events = Event::all();
        $ticketTiers = TicketTier::all();
        $attendees = Attendee::all();

        return view('event-registrations.edit', ['eventRegistration' => $loaded, 'events' => $events, 'ticketTiers' => $ticketTiers, 'attendees' => $attendees]);
    }

    public function edit(EventRegistration $eventRegistration)
    {
        $events = Event::all();
        $ticketTiers = TicketTier::all();
        $attendees = Attendee::all();

        return view('event-registrations.edit', compact('eventRegistration', 'events', 'ticketTiers', 'attendees'));
    }

    public function update(Request $request, EventRegistration $eventRegistration)
    {
        $data = $request->validate([
            'event_id' => ['sometimes', 'required', 'integer', 'exists:events,id'],
            'ticket_tier_id' => ['sometimes', 'required', 'integer', 'exists:ticket_tiers,id'],
            'attendee_id' => ['sometimes', 'required', 'integer', 'exists:attendees,id'],
            'registration_code' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('event_registrations', 'registration_code')->ignore($eventRegistration->id)],
            'qr_code_hash' => ['sometimes', 'required', 'string', 'max:255'],
            'payment_status' => ['sometimes', Rule::in(['Pending', 'Paid', 'Cancelled'])],
            'attendance_status' => ['sometimes', Rule::in(['Belum Hadir', 'Hadir'])],
        ]);

        $eventRegistration->update($data);

        if ($request->wantsJson()) {
            return response()->json($eventRegistration->fresh()->load(['event', 'ticketTier', 'attendee']));
        }

        return redirect()->route('event-registrations.index')->with('success', 'Registrasi berhasil diperbarui.');
    }

    public function destroy(Request $request, EventRegistration $eventRegistration)
    {
        $eventRegistration->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Registrasi berhasil dihapus.']);
        }

        return redirect()->route('event-registrations.index')->with('success', 'Registrasi berhasil dihapus.');
    }
}
