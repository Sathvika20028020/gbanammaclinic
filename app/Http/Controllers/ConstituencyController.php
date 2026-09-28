<?php

namespace App\Http\Controllers;

use App\Models\Constituency;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Models\Corporation;

class ConstituencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $constituencies = Constituency::with('zone.corporation')
            ->orderBy('name')
            ->get();

        return view('constituencies.index', compact('constituencies'));
    }

    public function create()
    {
        $zones = Zone::with('corporation')->orderBy('name')->get();
        return view('constituencies.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
        ]);

        Constituency::create($validated);

        return redirect()
            ->route('constituencies.index')
            ->with('success', 'Constituency created successfully!');
    }

    public function show($id)
    {
        $constituency = Constituency::with(['zone.corporation', 'wards'])
            ->findOrFail($id);

        return view('constituencies.show', compact('constituency'));
    }

    public function edit($id)
    {
        $constituency = Constituency::with('zone.corporation')->findOrFail($id);

        $zones = Zone::with('corporation')->orderBy('name')->get();
        $corporations = Corporation::orderBy('name')->get();

        return view('constituencies.edit', compact('constituency', 'zones', 'corporations'));
    }


    public function update(Request $request, $id)
    {
        $constituency = Constituency::findOrFail($id);

        $validated = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
        ]);

        $constituency->update($validated);

        return redirect()
            ->route('constituencies.show', $constituency->id)
            ->with('success', 'Constituency updated successfully!');
    }
}
