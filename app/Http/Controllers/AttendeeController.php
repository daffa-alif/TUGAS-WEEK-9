<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendeeController extends Controller
{
    public function index(Request $request)
    {
        $attendees = Attendee::with('registrations.event', 'registrations.ticketTier')->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($attendees);
        }

        return view('attendees.index', compact('attendees'));
    }

    public function create()
    {
        return view('attendees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:attendees,email'],
            'phone' => ['nullable', 'string', 'max:25'],
            'institution' => ['nullable', 'string', 'max:150'],
        ]);

        $attendee = Attendee::create($data);

        if ($request->wantsJson()) {
            return response()->json($attendee, 201);
        }

        return redirect()->route('attendees.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function show(Request $request, Attendee $attendee)
    {
        $loaded = $attendee->load('registrations.event', 'registrations.ticketTier');

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        return view('attendees.edit', ['attendee' => $loaded]);
    }

    public function edit(Attendee $attendee)
    {
        return view('attendees.edit', compact('attendee'));
    }

    public function update(Request $request, Attendee $attendee)
    {
        $data = $request->validate([
            'full_name' => ['sometimes', 'required', 'string', 'max:150'],
            'email' => ['sometimes', 'required', 'email', 'max:150', Rule::unique('attendees', 'email')->ignore($attendee->id)],
            'phone' => ['sometimes', 'nullable', 'string', 'max:25'],
            'institution' => ['sometimes', 'nullable', 'string', 'max:150'],
        ]);

        $attendee->update($data);

        if ($request->wantsJson()) {
            return response()->json($attendee->fresh());
        }

        return redirect()->route('attendees.index')->with('success', 'Peserta berhasil diperbarui.');
    }

    public function destroy(Request $request, Attendee $attendee)
    {
        $attendee->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Peserta berhasil dihapus.']);
        }

        return redirect()->route('attendees.index')->with('success', 'Peserta berhasil dihapus.');
    }
}
