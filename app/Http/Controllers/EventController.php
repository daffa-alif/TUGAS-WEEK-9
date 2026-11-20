<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with(['syllabuses', 'ticketTiers', 'speakers'])->paginate(15);

        if ($request->wantsJson()) {
            return response()->json($events);
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_code' => ['required', 'string', 'max:20', 'unique:events,event_code'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['Teknologi', 'Bisnis'])],
            'description' => ['required', 'string'],
            'session_duration' => ['required', 'integer', 'min:1', 'max:65535'],
            'total_sessions' => ['required', 'integer', 'min:1', 'max:255'],
            'status' => ['sometimes', Rule::in(['Draft', 'Published', 'Archived'])],
        ]);

        $event = Event::create($data);

        if ($request->wantsJson()) {
            return response()->json($event->load(['syllabuses', 'ticketTiers']), 201);
        }

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function show(Request $request, Event $event)
    {
        $loadedEvent = $event->load(['syllabuses', 'ticketTiers', 'registrations.attendee', 'registrations.ticketTier', 'speakers']);

        if ($request->wantsJson()) {
            return response()->json($loadedEvent);
        }

        return view('events.edit', ['event' => $loadedEvent]);
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'event_code' => ['sometimes', 'required', 'string', 'max:20', Rule::unique('events', 'event_code')->ignore($event->id)],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'category' => ['sometimes', 'required', Rule::in(['Teknologi', 'Bisnis'])],
            'description' => ['sometimes', 'required', 'string'],
            'session_duration' => ['sometimes', 'required', 'integer', 'min:1', 'max:65535'],
            'total_sessions' => ['sometimes', 'required', 'integer', 'min:1', 'max:255'],
            'status' => ['sometimes', 'required', Rule::in(['Draft', 'Published', 'Archived'])],
        ]);

        $event->update($data);

        if ($request->wantsJson()) {
            return response()->json($event->fresh()->load(['syllabuses', 'ticketTiers']));
        }

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Request $request, Event $event)
    {
        $event->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Event berhasil diarsipkan.']);
        }

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus/diarsipkan.');
    }
}
