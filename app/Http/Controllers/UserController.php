<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ward;
use App\Models\Constituency;
use App\Models\Corporation;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use PDF;

class UserController extends Controller
{
    /**
     * List all users (Admin only)
     */
   public function index()
{
    $this->authorize('viewAny', User::class);

    // Eager load both 'ward' and 'constituency'
    $users = User::with(['ward', 'constituency'])->latest()->get();
    
    // Fetching wards and constituencies for filters/modals if needed
    $wards = Ward::select('id', 'name')->get();
    $constituencies = \App\Models\Constituency::select('id', 'name')->get();
    $corporations=Corporation::select('id','name')->get();
    $zones=Zone::select('id','name')->get();

    return view('users.index', compact('users', 'wards', 'constituencies','corporations'));
}
    /**
     * Show Create User page (Admin only)
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $wards = Ward::orderByRaw('number + 0 ASC')->get();

        return view('users.create', compact('wards'));
    }

    /**
     * Store new user (Admin only)
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'ward_id'         => 'required|exists:wards,id',
            'clinic_name'     => 'required|string',
            'password'        => 'required|string|min:4',
            'email'           => 'required|email|unique:users,email',
            'internet_status' => 'required|in:active,inactive',
            'name'            => 'required|string',
            'phone'           => 'required|digits:10|unique:users,phone',
            'internet_speed'  => 'required|string',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
        ]);

        $validated['bandwidth'] = 'Unlimited';
        $validated['validity']  = 6;
        $validated['items_provided'] = ["Router", "Cable", "Adapter"];
        $validated['password'] = Hash::make($validated['password']);

        DB::transaction(function () use ($validated) {
            $user = User::create($validated);
            $user->assignRole('user');
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * View User Profile (Admin: any user, User: only self)
     */
    public function show($id)
    {
        $user = User::with(['ward', 'installation'])->findOrFail($id);

        $this->authorize('view', $user);

        $installationData = $this->prepareInstallationData($user);

        return view('users.show', compact('user', 'installationData'));
    }

    /**
     * Edit User Page (Admin: any user, User: only self)
     */
    public function edit($id)
    {
        $user = User::with('ward')->findOrFail($id);

        $this->authorize('update', $user);

        $wards = Ward::orderBy('name')->get();

        return view('users.edit', compact('user', 'wards'));
    }

    /**
     * Update User (Admin: any user, User: only self)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $validated = $request->validate([
            'ward_id'         => 'required|exists:wards,id',
            'clinic_name'     => 'required|string',
            'internet_status' => 'required|in:active,inactive',
            'name'            => 'required|string',
            'phone'           => "required|digits:10|unique:users,phone,{$user->id}",
            'internet_speed'  => 'required|string',
            'email'           => "required|email|unique:users,email,{$user->id}",
            'password'        => 'nullable|min:4',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['bandwidth'] = 'Unlimited';
        $validated['validity']  = 6;
        $validated['items_provided'] = ["Router", "Cable", "Adapter"];

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete User (Admin only — user cannot delete)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);

        // Prevent admin from deleting own account
        if (auth()->id() === $user->id) {
            return back()->with('error', "You cannot delete your own account.");
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Update Internet Status (Admin only)
     */
    public function updateStatus(Request $request)
    {
        $this->authorize('updateStatus', User::class);

        $request->validate([
            'id' => 'required|exists:users,id',
            'internet_status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($request->id);

        if (auth()->id() == $user->id) {
            return response()->json([
                'error' => true,
                'message' => 'You cannot change your own status.'
            ], 403);
        }

        $user->update(['internet_status' => $request->internet_status]);

        return response()->json(['success' => true]);
    }

    /**
     * Prepare installation info (same as before)
     */
    private function prepareInstallationData(User $user): ?array
    {
        if (!$user->installation) {
            return null;
        }

        $inst = $user->installation;

        return [
            'installed_on' => $inst->installed_on
                ? Carbon::parse($inst->installed_on)->format('d M Y')
                : null,

            'expiry_date' => $inst->installed_on
                ? Carbon::parse($inst->installed_on)->addMonths(6)->format('d M Y')
                : null,

            'routes' => $inst->routes,
            'cables' => $inst->cables,
            'has_items' => filled($inst->routes) || filled($inst->cables),
            'image' => $inst->image ? asset('storage/' . $inst->image) : null,
        ];
    }
    public function downloadPdf($id)
    {
        $user = User::with(['ward','Constituency', 'installation'])->findOrFail($id);

        $pdf = PDF::loadView('users.pdf', compact('user'))->setPaper('a4');

        return $pdf->download('user-profile-' . $user->id . '.pdf');
    }
}
