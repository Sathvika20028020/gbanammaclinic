<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Ward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tickets = Ticket::with(['user.ward'])
            ->when(!$user->hasRole('admin'), function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })
            ->latest()
            ->get();

        $wards = Ward::select('id', 'name')->get();

        return view('tickets.index', compact('tickets', 'wards', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $users = null;

        if ($user->hasRole('admin')) {
            $users = User::role('user')
                ->with('ward')
                ->orderBy('clinic_name')
                ->get();

            // If no user with role 'user', get all users except current admin
            if ($users->isEmpty()) {
                $users = User::where('id', '!=', $user->id)
                    ->with('ward')
                    ->orderBy('clinic_name')
                    ->get();
            }
        }

        return view('tickets.create', compact('user', 'users'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $rules = [
            'description'         => 'required|string|max:5000',
            'contact_person_name' => 'required|string|max:255',
            'phone'               => 'required|digits:10|regex:/^[0-9]{10}$/',
        ];

        if ($currentUser->hasRole('admin')) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        $targetUserId = $currentUser->hasRole('admin') ? $validated['user_id'] : $currentUser->id;

        Ticket::create([
            'user_id'             => $targetUserId,
            'description'         => $validated['description'],
            'status'              => 'Pending',
            'phone'               => $validated['phone'],
            'contact_person_name' => $validated['contact_person_name'],
            'admin_remarks'       => null,
            'admin_image'         => null,
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket raised successfully!');
    }

    public function show($id)
    {
        $ticket = Ticket::with(['user.ward'])->findOrFail($id);

        $currentUser = Auth::user();
        if (!$currentUser->hasRole('admin') && $ticket->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to this ticket.');
        }

        return view('tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $user = Auth::user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Only admins can resolve tickets.');
        }

        $ticket = Ticket::with(['user.ward'])->findOrFail($id);

        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Only admins can resolve tickets.');
        }

        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'admin_remarks' => 'nullable|string|max:5000',
            'status'        => 'required|in:Pending,Irrelevant,Resolved',
            'admin_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'admin_remarks' => $validated['admin_remarks'] ?? null,
            'status'        => $validated['status'],
        ];

        // Handle image upload
        if ($request->hasFile('admin_image')) {
            // Delete previous image if exists
            if ($ticket->admin_image) {
                Storage::disk('public')->delete($ticket->admin_image);
            }

            // Generate unique filename
            $filename = Str::uuid() . '.' . $request->file('admin_image')->extension();

            // Store safely in public disk
            $storedPath = $request->file('admin_image')
                                  ->storeAs('ticket_resolutions', $filename, 'public');

            $data['admin_image'] = $storedPath;
        }

        $ticket->update($data);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket status updated successfully!');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Only admins can delete tickets.');
        }

        $ticket = Ticket::findOrFail($id);

        if ($ticket->admin_image) {
            Storage::disk('public')->delete($ticket->admin_image);
        }

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }
}
