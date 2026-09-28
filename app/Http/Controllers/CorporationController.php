<?php

namespace App\Http\Controllers;

use App\Models\Corporation;
use Illuminate\Http\Request;

class CorporationController extends Controller
{
    /**
     * ADMIN: List all corporations
     */
    public function index()
    {
        $this->authorizeAdmin();
        $corporations = Corporation::all();
        return view('corporations.index', compact('corporations'));
    }

    /**
     * ADMIN: Show create form
     */
    public function create()
    {
        $this->authorizeAdmin();
        return view('corporations.create');
    }

    /**
     * ADMIN: Store corporation
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string|unique:corporations,name',
        ]);

        Corporation::create($validated);

        return redirect()
            ->route('corporations.index')
            ->with('success', 'Corporation added successfully!');
    }

    /**
     * View a specific corporation
     */
    public function show($id)
    {
        $corporation = Corporation::findOrFail($id);
        return view('corporations.show', compact('corporation'));
    }

    /**
     * ADMIN: Edit form
     */
    public function edit($id)
    {
        $this->authorizeAdmin();
        $corporation = Corporation::findOrFail($id);
        return view('corporations.edit', compact('corporation'));
    }

    /**
     * ADMIN: Update corporation
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $corporation = Corporation::findOrFail($id);

        $validated = $request->validate([
            'name' => "required|string|unique:corporations,name,$id",
        ]);

        $corporation->update($validated);

        return redirect()
            ->route('corporations.index')
            ->with('success', 'Corporation updated successfully!');
    }

    /**
     * ADMIN: Delete corporation
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $corporation = Corporation::findOrFail($id);
        $corporation->delete();

        return redirect()
            ->route('corporations.index')
            ->with('success', 'Corporation deleted successfully!');
    }

    /**
     * Allow only Admin
     */
    private function authorizeAdmin()
    {
        abort_unless(auth()->user()->hasRole('admin'), 403, 'Unauthorized');
    }
}
