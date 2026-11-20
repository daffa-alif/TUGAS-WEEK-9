<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Compatibility controller for the original Peserta naming.
 * Uses the consolidated Attendee table/model through inheritance or redirection to views.
 */
class PesertaController extends AttendeeController
{
    public function index(Request $request)
    {
        $peserta = Attendee::with('registrations.event', 'registrations.ticketTier')->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($peserta);
        }

        return view('peserta.index', compact('peserta'));
    }

    public function create()
    {
        return view('peserta.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:attendees,email'],
            'phone' => ['nullable', 'string', 'max:25'],
            'institution' => ['nullable', 'string', 'max:150'],
        ]);

        $peserta = Attendee::create($data);

        if ($request->wantsJson()) {
            return response()->json($peserta, 201);
        }

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function show(Request $request, Attendee $peserta)
    {
        $loaded = $peserta->load('registrations.event', 'registrations.ticketTier');

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        return view('peserta.edit', ['peserta' => $loaded]);
    }

    public function edit(Attendee $peserta)
    {
        return view('peserta.edit', compact('peserta'));
    }

    public function update(Request $request, Attendee $peserta)
    {
        $data = $request->validate([
            'full_name' => ['sometimes', 'required', 'string', 'max:150'],
            'email' => ['sometimes', 'required', 'email', 'max:150', Rule::unique('attendees', 'email')->ignore($peserta->id)],
            'phone' => ['sometimes', 'nullable', 'string', 'max:25'],
            'institution' => ['sometimes', 'nullable', 'string', 'max:150'],
        ]);

        $peserta->update($data);

        if ($request->wantsJson()) {
            return response()->json($peserta->fresh());
        }

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil diperbarui.');
    }

    public function destroy(Request $request, Attendee $peserta)
    {
        $peserta->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Peserta berhasil dihapus.']);
        }

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil dihapus.');
    }
}
