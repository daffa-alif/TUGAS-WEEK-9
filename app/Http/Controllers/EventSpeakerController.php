<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventSpeaker;
use App\Models\EventSyllabus;
use App\Models\Speaker;
use Illuminate\Http\Request;

class EventSpeakerController extends Controller
{
    public function index(Request $request)
    {
        $query = EventSpeaker::with(['event', 'speaker', 'syllabus']);

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->integer('event_id'));
        }
        if ($request->filled('speaker_id')) {
            $query->where('speaker_id', $request->integer('speaker_id'));
        }

        $eventSpeakers = $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($eventSpeakers);
        }

        return view('event-speakers.index', compact('eventSpeakers'));
    }

    public function create()
    {
        $events = Event::all();
        $speakers = Speaker::all();
        $syllabuses = EventSyllabus::all();

        return view('event-speakers.create', compact('events', 'speakers', 'syllabuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'speaker_id' => ['required', 'integer', 'exists:speakers,id'],
            'syllabus_id' => ['nullable', 'integer', 'exists:event_syllabuses,id'],
            'role_topic' => ['nullable', 'string', 'max:150'],
        ]);

        $speakerRel = EventSpeaker::create($data);

        if ($request->wantsJson()) {
            return response()->json($speakerRel->load(['event', 'speaker', 'syllabus']), 201);
        }

        return redirect()->route('event-speakers.index')->with('success', 'Event Speaker berhasil ditambahkan.');
    }

    public function show(Request $request, EventSpeaker $eventSpeaker)
    {
        $loaded = $eventSpeaker->load(['event', 'speaker', 'syllabus']);

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        $events = Event::all();
        $speakers = Speaker::all();
        $syllabuses = EventSyllabus::all();

        return view('event-speakers.edit', ['eventSpeaker' => $loaded, 'events' => $events, 'speakers' => $speakers, 'syllabuses' => $syllabuses]);
    }

    public function edit(EventSpeaker $eventSpeaker)
    {
        $events = Event::all();
        $speakers = Speaker::all();
        $syllabuses = EventSyllabus::all();

        return view('event-speakers.edit', compact('eventSpeaker', 'events', 'speakers', 'syllabuses'));
    }

    public function update(Request $request, EventSpeaker $eventSpeaker)
    {
        $data = $request->validate([
            'event_id' => ['sometimes', 'required', 'integer', 'exists:events,id'],
            'speaker_id' => ['sometimes', 'required', 'integer', 'exists:speakers,id'],
            'syllabus_id' => ['sometimes', 'nullable', 'integer', 'exists:event_syllabuses,id'],
            'role_topic' => ['sometimes', 'nullable', 'string', 'max:150'],
        ]);

        $eventSpeaker->update($data);

        if ($request->wantsJson()) {
            return response()->json($eventSpeaker->fresh()->load(['event', 'speaker', 'syllabus']));
        }

        return redirect()->route('event-speakers.index')->with('success', 'Event Speaker berhasil diperbarui.');
    }

    public function destroy(Request $request, EventSpeaker $eventSpeaker)
    {
        $eventSpeaker->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Relasi event-speaker berhasil dihapus.']);
        }

        return redirect()->route('event-speakers.index')->with('success', 'Event Speaker berhasil dihapus.');
    }
}
