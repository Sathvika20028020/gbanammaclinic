<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\User;
use App\Models\Corporation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class InstallationController extends Controller
{

    /**
     * Admin: List all installations
     */
    public function index()
    {
        $this->authorizeAdmin();

        $installations = Installation::with(['user.ward', 'user.constituency','user.corporation','user.zone'])
        ->latest()
        ->get();

        return view('installations.index', compact('installations'));
    }


    /**
     * Admin: Show create form
     */
    public function create()
    {
        $this->authorizeAdmin();

        $users = User::select('id', 'name', 'clinic_name')
            ->orderBy('name')
            ->get();

        return view('installations.create', compact('users'));
    }


    /**
     * Admin: Store installation
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([

            'user_id'      => 'required|exists:users,id',
            'installed_on' => 'required|date',

            'comments'     => 'nullable|string|max:5000',
            'routes'       => 'nullable|string|max:1000',
            'cables'       => 'nullable|string|max:1000',

            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:10121',

            // ✅ GPS IMAGE
            'gps_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:10121',

            // GPS coordinates
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',

        ]);

        // inherit ward automatically
        $selectedUser = User::select('id','ward_id')
            ->findOrFail($validated['user_id']);

        $data = [

            'user_id'      => $selectedUser->id,
            'ward_id'      => $selectedUser->ward_id,

            'installed_on' => $validated['installed_on'],

            'comments'     => $validated['comments'] ?? null,
            'routes'       => $validated['routes'] ?? null,
            'cables'       => $validated['cables'] ?? null,

            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,

            'uploaded_ip'  => $request->ip(),
        ];


        /** ---------------------------
         * Installation Image Upload
         * --------------------------- */

        if ($request->hasFile('image')) {

            $filename = Str::uuid().'.'.$request
                ->file('image')
                ->extension();

            $data['image'] = $request
                ->file('image')
                ->storeAs(
                    'installation_images',
                    $filename,
                    'public'
                );
        }


        /** ---------------------------
         * GPS Image Upload
         * --------------------------- */

        if ($request->hasFile('gps_image')) {

            $gpsFilename = Str::uuid().'.'.$request
                ->file('gps_image')
                ->extension();

            $data['gps_image'] = $request
                ->file('gps_image')
                ->storeAs(
                    'installation_gps_images',
                    $gpsFilename,
                    'public'
                );
        }


        Installation::create($data);

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation created successfully!');
    }


    /**
     * Admin: View installation details
     */
    public function show($id)
    {
        $this->authorizeAdmin();

        $installation = Installation::with(['user.ward'])
            ->findOrFail($id);

        return view('installations.show', compact('installation'));
    }


    /**
     * Admin: Delete installation
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $installation = Installation::findOrFail($id);

        // delete installation image
        if ($installation->image) {

            Storage::disk('public')
                ->delete($installation->image);
        }

        // ✅ delete GPS image
        if ($installation->gps_image) {

            Storage::disk('public')
                ->delete($installation->gps_image);
        }

        $installation->delete();

        return redirect()
            ->route('installations.index')
            ->with('success', 'Installation deleted successfully!');
    }


    public function pdf($id)
    {
        $installation = Installation::with(['user.ward'])
            ->findOrFail($id);

        $pdf = PDF::loadView(
            'installations.pdf',
            compact('installation')
        )->setPaper('a4');

        return $pdf->download(
            'installation-' . $installation->id . '.pdf'
        );
    }


    public function downloadDeclarationPdf($id)
    {
        $this->authorizeAdmin();

        $installation = Installation::with(['user.ward'])
            ->findOrFail($id);

        return Pdf::loadView(
            'installations.declaration_pdf',
            compact('installation')
        )
        ->setPaper('a4','portrait')
        ->download(
            'installation-declaration-'.$installation->id.'.pdf'
        );
    }


    private function authorizeAdmin()
    {
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {

            abort(403,'Access denied.');
        }
    }
}