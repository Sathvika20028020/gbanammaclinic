<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Corporation;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /** List */
    public function index()
    {
        $zones = Zone::with('corporation')->get();
        return view('zones.index', compact('zones'));
    }

    /** Show */
    public function show($id)
    {
        $zone = Zone::with('corporation')->findOrFail($id);
        return view('zones.show', compact('zone'));
    }

    /** Create Form */
    public function create()
    {
        $corporations = Corporation::select('id', 'name')->get();
        return view('zones.create', compact('corporations'));
    }

    /** Store */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'corporation_id' => 'required|exists:corporations,id',
        
           
        ]);

        Zone::create($validated);

        return redirect()->route('zones.index')
            ->with('success', 'Zone created successfully!');
    }

    /** Edit Form */
    public function edit($id)
    {
        $zone = Zone::findOrFail($id);
        $corporations = Corporation::select('id', 'name')->get();

        return view('zones.edit', compact('zone', 'corporations'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'corporation_id' => 'required|exists:corporations,id',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',

        ]);

        $zone = Zone::findOrFail($id);
        $zone->update($validated);

        return redirect()->route('zones.index')
            ->with('success', 'Zone updated successfully!');
    }
}
