<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Phc;
use App\Models\Ward;
use Illuminate\Http\Request;

class PhcController extends Controller
{
   
    public function index()
    {
        $phcs = Phc::with('ward.constituency.zone.corporation')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('phcs.index', compact('phcs'));
    }

  
    public function create()
    {

        $wards = Ward::orderByRaw('number + 0 ASC')->get();

        return view('phcs.create', compact('wards'));
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'ward_id' => ['required', 'exists:wards,id'],
        ]);

       
        $duplicate = Phc::where('ward_id', $validated['ward_id'])
            ->where('name', $validated['name'])
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors([
                    'name' => 'This PHC already exists for the selected ward.',
                ])
                ->withInput();
        }

        Phc::create([
            'name'    => $validated['name'],
            'ward_id' => $validated['ward_id'],
            'active'  => true,
        ]);

        return redirect()
            ->route('phcs.index')
            ->with('success', 'PHC created successfully.');
    }

  
    public function show(Phc $phc)
    {
        $phc->load('ward.constituency.zone.corporation');

        return view('phcs.show', compact('phc'));
    }


    public function edit(Phc $phc)
    {
        $wards = Ward::orderBy('number', 'asc')
            ->get(['id', 'number', 'name']);

        return view('phcs.edit', compact('phc', 'wards'));
    }

   
    public function update(Request $request, Phc $phc)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'ward_id' => ['required', 'exists:wards,id'],
        ]);

        
        $duplicate = Phc::where('ward_id', $validated['ward_id'])
            ->where('name', $validated['name'])
            ->where('id', '!=', $phc->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors([
                    'name' => 'This PHC already exists for the selected ward.',
                ])
                ->withInput();
        }

        $phc->update([
            'name'    => $validated['name'],
            'ward_id' => $validated['ward_id'],
        ]);

        return redirect()
            ->route('phcs.index')
            ->with('success', 'PHC updated successfully.');
    }

   
    public function destroy(Phc $phc)
    {
        $phc->delete();

        return redirect()
            ->route('phcs.index')
            ->with('success', 'PHC deleted successfully.');
    }
}
