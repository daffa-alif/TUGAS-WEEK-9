<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar semua event dalam bentuk tampilan Blade.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(10);

        // Ubah response()->json() menjadi view()
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    /**
     * Menyimpan data event baru dari form Blade.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_code'       => ['required', 'string', 'max:20', 'unique:events,event_code'],
            'title'            => ['required', 'string', 'max:255'],
            'category'         => ['required', Rule::in(['Teknologi', 'Bisnis'])],
            'description'      => ['required', 'string'],
            'session_duration' => ['required', 'integer', 'min:1'],
            'total_sessions'   => ['required', 'integer', 'min:1'],
            'status'           => ['required', Rule::in(['Draft', 'Published', 'Archived'])],
        ]);

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit event.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('events.edit', compact('event'));
    }

    /**
     * Memperbarui data event dari form edit.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'event_code'       => ['required', 'string', 'max:20', Rule::unique('events', 'event_code')->ignore($event->id)],
            'title'            => ['required', 'string', 'max:255'],
            'category'         => ['required', Rule::in(['Teknologi', 'Bisnis'])],
            'description'      => ['required', 'string'],
            'session_duration' => ['required', 'integer', 'min:1'],
            'total_sessions'   => ['required', 'integer', 'min:1'],
            'status'           => ['required', Rule::in(['Draft', 'Published', 'Archived'])],
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Menghapus event (Soft Delete).
     */
public function destroy($id)
{
    $event = Event::findOrFail($id);
    $event->forceDelete(); // Menghapus permanen dari database

    return redirect()->route('events.index')->with('success', 'Event berhasil dihapus secara permanen!');
}
}