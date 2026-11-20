<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventSyllabus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventSyllabusController extends Controller
{
    public function index(Request $request)
    {
        $query = EventSyllabus::with('event');

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->integer('event_id'));
        }

        $syllabuses = $query->orderBy('event_id')->orderBy('module_number')->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($syllabuses);
        }

        return view('event-syllabuses.index', compact('syllabuses'));
    }

    public function create()
    {
        $events = Event::all();
        return view('event-syllabuses.create', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'module_number' => [
                'required', 'integer', 'min:1', 'max:255',
                Rule::unique('event_syllabuses', 'module_number')
                    ->where(fn ($query) => $query->where('event_id', $request->input('event_id'))),
            ],
            'title' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1', 'max:65535'],
            'description' => ['nullable', 'string'],
        ]);

        $syllabus = EventSyllabus::create($data);

        if ($request->wantsJson()) {
            return response()->json($syllabus->load('event'), 201);
        }

        return redirect()->route('event-syllabuses.index')->with('success', 'Silabus berhasil ditambahkan.');
    }

    public function show(Request $request, EventSyllabus $eventSyllabus)
    {
        $loaded = $eventSyllabus->load(['event', 'eventSpeakers.speaker']);

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        $events = Event::all();
        return view('event-syllabuses.edit', ['eventSyllabus' => $loaded, 'events' => $events]);
    }

    public function edit(EventSyllabus $eventSyllabus)
    {
        $events = Event::all();
        return view('event-syllabuses.edit', compact('eventSyllabus', 'events'));
    }

    public function update(Request $request, EventSyllabus $eventSyllabus)
    {
        $data = $request->validate([
            'event_id' => ['sometimes', 'required', 'integer', 'exists:events,id'],
            'module_number' => [
                'sometimes', 'required', 'integer', 'min:1', 'max:255',
                Rule::unique('event_syllabuses', 'module_number')
                    ->where(fn ($query) => $query->where('event_id', $request->input('event_id', $eventSyllabus->event_id)))
                    ->ignore($eventSyllabus->id),
            ],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'duration' => ['sometimes', 'required', 'integer', 'min:1', 'max:65535'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);

        $eventSyllabus->update($data);

        if ($request->wantsJson()) {
            return response()->json($eventSyllabus->fresh()->load('event'));
        }

        return redirect()->route('event-syllabuses.index')->with('success', 'Silabus berhasil diperbarui.');
    }

    public function destroy(Request $request, EventSyllabus $eventSyllabus)
    {
        $eventSyllabus->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Silabus berhasil dihapus.']);
        }

        return redirect()->route('event-syllabuses.index')->with('success', 'Silabus berhasil dihapus.');
    }
}
