<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Constituency;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * List of wards
     */
    public function index()
    {
        $wards = Ward::with(['constituency.zone.corporation'])
            ->orderByRaw('number + 0 ASC')
            ->get();

        return view('wards.index', compact('wards'));
    }

    /**
     * Show single ward detail page
     */
    public function show($id)
    {
        $ward = Ward::with(['constituency.zone.corporation'])
            ->findOrFail($id);

        return view('wards.show', compact('ward'));
    }

    /**
     * Create form UI
     */
    public function create()
    {
        $constituencies = Constituency::with('zone')->orderBy('name')->get();
        return view('wards.create', compact('constituencies'));
    }

    /**
     * Store new ward into DB
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'number'          => 'required|string|max:10|unique:wards,number',
            'constituency_id' => 'required|exists:constituencies,id',

        ]);

        Ward::create($validated);

        return redirect()
            ->route('wards.index')
            ->with('success', 'Ward created successfully!');
    }

    /**
     * Edit form UI
     */
    public function edit($id)
    {
        $ward = Ward::findOrFail($id);
        $constituencies = Constituency::with('zone')->orderBy('name')->get();

        return view('wards.edit', compact('ward', 'constituencies'));
    }

    /**
     * Update existing ward
     */
    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'number'          => 'required|string|max:10|unique:wards,number,' . $ward->id,
            'constituency_id' => 'required|exists:constituencies,id',
            'status'          => 'required|boolean',
        ]);

        $ward->update($validated);

        return redirect()
            ->route('wards.show', $ward->id)
            ->with('success', 'Ward updated successfully!');
    }
}
