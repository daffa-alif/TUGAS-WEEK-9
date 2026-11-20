<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpeakerController extends Controller
{
    public function index(Request $request)
    {
        $speakers = Speaker::with('events')->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($speakers);
        }

        return view('speakers.index', compact('speakers'));
    }

    public function create()
    {
        return view('speakers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:speakers,email'],
            'expertise' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:150'],
            'bio' => ['nullable', 'string'],
        ]);

        $speaker = Speaker::create($data);

        if ($request->wantsJson()) {
            return response()->json($speaker, 201);
        }

        return redirect()->route('speakers.index')->with('success', 'Speaker berhasil ditambahkan.');
    }

    public function show(Request $request, Speaker $speaker)
    {
        $loaded = $speaker->load(['events', 'eventSpeakers.syllabus']);

        if ($request->wantsJson()) {
            return response()->json($loaded);
        }

        return view('speakers.edit', ['speaker' => $loaded]);
    }

    public function edit(Speaker $speaker)
    {
        return view('speakers.edit', compact('speaker'));
    }

    public function update(Request $request, Speaker $speaker)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:150'],
            'email' => ['sometimes', 'required', 'email', 'max:150', Rule::unique('speakers', 'email')->ignore($speaker->id)],
            'expertise' => ['sometimes', 'required', 'string', 'max:255'],
            'institution' => ['sometimes', 'required', 'string', 'max:150'],
            'bio' => ['sometimes', 'nullable', 'string'],
        ]);

        $speaker->update($data);

        if ($request->wantsJson()) {
            return response()->json($speaker->fresh());
        }

        return redirect()->route('speakers.index')->with('success', 'Speaker berhasil diperbarui.');
    }

    public function destroy(Request $request, Speaker $speaker)
    {
        $speaker->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Speaker berhasil dihapus.']);
        }

        return redirect()->route('speakers.index')->with('success', 'Speaker berhasil dihapus.');
    }
}
