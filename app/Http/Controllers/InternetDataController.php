<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\InstallationRecharge;
use App\Models\User;
use App\Models\Ward;
use App\Models\Corporation;
use App\Models\Constituency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InternetDataController extends Controller
{
    /**
     * Display a listing of internet data records.
     */
    public function index(Request $request)
    {
        $query = Installation::with([
            'user.ward.constituency.zone.corporation',
            'ward.constituency.zone.corporation',
            'recharges',
        ]);

        // Filter by Corporation
        if ($request->filled('corporation')) {
            $query->whereHas('ward.constituency.zone.corporation', function ($q) use ($request) {
                $q->where('name', $request->corporation);
            })->orWhereHas('user.ward.constituency.zone.corporation', function ($q) use ($request) {
                $q->where('name', $request->corporation);
            });
        }

        // Filter by Constituency
        if ($request->filled('constituency')) {
            $query->whereHas('ward.constituency', function ($q) use ($request) {
                $q->where('name', $request->constituency);
            })->orWhereHas('user.ward.constituency', function ($q) use ($request) {
                $q->where('name', $request->constituency);
            });
        }

        // Filter by Provider
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        // Filter by Date Range (Last Recharge Date)
        if ($request->filled('from_date')) {
            $query->whereDate('last_recharge_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('last_recharge_date', '<=', $request->to_date);
        }

        $installations = $query->latest('updated_at')->get();
        $corporations = Corporation::orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();

        return view('internetdata.index', compact('installations', 'corporations', 'constituencies'));
    }

    /**
     * Show the form for creating a new internet data / recharge entry.
     */
    public function create()
    {
        $users = User::select('id', 'name', 'clinic_name', 'phone', 'ward_id')
            ->with(['ward.constituency.zone.corporation'])
            ->orderBy('name')
            ->get();

        return view('internetdata.create', compact('users'));
    }

    /**
     * Store a newly created internet connection & recharge in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'provider'           => 'required|string|max:100',
            'internet_id'        => 'required|string|max:150',
            'internet_password'  => 'nullable|string|max:150',
            'last_recharge_date' => 'required|date',
            'plan_validity'      => 'required|string',
            'expiry_date'        => 'nullable|date',
            'status'             => 'required|string',
            'contact_person'     => 'nullable|string|max:150',
            'contact_no'         => 'nullable|string|max:20',
        ]);

        $user = User::with('ward')->findOrFail($validated['user_id']);

        // Calculate expiry date if not provided
        $rechargeDate = Carbon::parse($validated['last_recharge_date']);
        $expiryDate = $validated['expiry_date'] 
            ? Carbon::parse($validated['expiry_date']) 
            : $this->calculateExpiryDate($rechargeDate, $validated['plan_validity']);

        // Check if installation exists for this user, or create new
        $installation = Installation::firstOrNew(['user_id' => $user->id]);
        $installation->ward_id = $user->ward_id ?? $installation->ward_id;
        $installation->provider = $validated['provider'];
        $installation->internet_id = $validated['internet_id'];
        $installation->internet_password = $validated['internet_password'] ?? $installation->internet_password;
        $installation->last_recharge_date = $rechargeDate;
        $installation->recharge_expiry_date = $expiryDate;
        $installation->plan_validity = $validated['plan_validity'];
        $installation->status = $validated['status'];
        if (!$installation->installed_on) {
            $installation->installed_on = $rechargeDate;
        }
        $installation->save();

        // Add history log in installation_recharges
        InstallationRecharge::create([
            'installation_id' => $installation->id,
            'recharge_date'   => $rechargeDate,
            'expiry_date'     => $expiryDate,
            'plan_validity'   => $validated['plan_validity'],
            'created_by'      => Auth::id(),
            'remarks'         => 'Initial recharge logged via Internet Data form',
        ]);

        return redirect()->route('internetdata.index')
            ->with('success', 'Internet data and recharge recorded successfully.');
    }

    /**
     * Display the specified internet data & recharge history.
     */
    public function show($id)
    {
        $installation = Installation::with([
            'user.ward.constituency.zone.corporation',
            'ward.constituency.zone.corporation',
            'recharges.creator',
        ])->findOrFail($id);

        return view('internetdata.show', compact('installation'));
    }

    /**
     * Show the form for editing the specified internet data.
     */
    public function edit($id)
    {
        $installation = Installation::with([
            'user.ward.constituency.zone.corporation',
            'ward',
        ])->findOrFail($id);

        $users = User::select('id', 'name', 'clinic_name', 'phone', 'ward_id')
            ->with(['ward.constituency.zone.corporation'])
            ->orderBy('name')
            ->get();

        return view('internetdata.edit', compact('installation', 'users'));
    }

    /**
     * Update the specified internet data in storage.
     */
    public function update(Request $request, $id)
    {
        $installation = Installation::findOrFail($id);

        $validated = $request->validate([
            'provider'           => 'required|string|max:100',
            'internet_id'        => 'required|string|max:150',
            'internet_password'  => 'nullable|string|max:150',
            'last_recharge_date' => 'required|date',
            'plan_validity'      => 'required|string',
            'expiry_date'        => 'nullable|date',
            'status'             => 'required|string',
        ]);

        $rechargeDate = Carbon::parse($validated['last_recharge_date']);
        $expiryDate = $validated['expiry_date'] 
            ? Carbon::parse($validated['expiry_date']) 
            : $this->calculateExpiryDate($rechargeDate, $validated['plan_validity']);

        $installation->provider = $validated['provider'];
        $installation->internet_id = $validated['internet_id'];
        if (!empty($validated['internet_password'])) {
            $installation->internet_password = $validated['internet_password'];
        }
        $installation->last_recharge_date = $rechargeDate;
        $installation->recharge_expiry_date = $expiryDate;
        $installation->plan_validity = $validated['plan_validity'];
        $installation->status = $validated['status'];
        $installation->save();

        return redirect()->route('internetdata.show', $installation->id)
            ->with('success', 'Internet data updated successfully.');
    }

    /**
     * Store a new recharge record for an existing installation.
     */
    public function storeRecharge(Request $request, $id)
    {
        $installation = Installation::findOrFail($id);

        $validated = $request->validate([
            'recharge_date' => 'required|date',
            'plan_validity' => 'required|string',
            'expiry_date'   => 'nullable|date',
            'amount'        => 'nullable|numeric|min:0',
            'receipt_no'    => 'nullable|string|max:100',
            'remarks'       => 'nullable|string|max:500',
        ]);

        $rechargeDate = Carbon::parse($validated['recharge_date']);
        $expiryDate = $validated['expiry_date'] 
            ? Carbon::parse($validated['expiry_date']) 
            : $this->calculateExpiryDate($rechargeDate, $validated['plan_validity']);

        // Create recharge record
        InstallationRecharge::create([
            'installation_id' => $installation->id,
            'recharge_date'   => $rechargeDate,
            'expiry_date'     => $expiryDate,
            'plan_validity'   => $validated['plan_validity'],
            'amount'          => $validated['amount'] ?? null,
            'receipt_no'      => $validated['receipt_no'] ?? null,
            'remarks'         => $validated['remarks'] ?? null,
            'created_by'      => Auth::id(),
        ]);

        // Update installation master record
        $installation->last_recharge_date = $rechargeDate;
        $installation->recharge_expiry_date = $expiryDate;
        $installation->plan_validity = $validated['plan_validity'];
        $installation->status = 'active';
        $installation->save();

        return redirect()->route('internetdata.show', $installation->id)
            ->with('success', 'New recharge record added successfully.');
    }

    /**
     * Helper to compute expiry date given recharge date and validity string.
     */
    private function calculateExpiryDate(Carbon $rechargeDate, string $validity): Carbon
    {
        $date = $rechargeDate->copy();
        switch (strtolower(trim($validity))) {
            case '1 month':
                return $date->addMonth();
            case '3 months':
                return $date->addMonths(3);
            case '6 months':
                return $date->addMonths(6);
            case '1 year':
                return $date->addYear();
            default:
                return $date->addMonth();
        }
    }

    /**
     * Export internet data to CSV.
     */
    public function export(Request $request)
    {
        $installations = Installation::with([
            'user.ward.constituency.zone.corporation',
            'ward.constituency.zone.corporation',
        ])->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="internet_data_recharges_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($installations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Sl No',
                'Clinic Name',
                'Corporation',
                'Constituency',
                'Ward',
                'Contact Person',
                'Contact No',
                'ISP Provider',
                'Internet ID',
                'Last Recharge',
                'Expiry Date',
                'Plan Validity',
                'Status',
            ]);

            foreach ($installations as $index => $ins) {
                $user = $ins->user;
                $ward = $user->ward ?? $ins->ward;
                $constituency = $ward?->constituency;
                $corporation = $constituency?->zone?->corporation;

                fputcsv($file, [
                    $index + 1,
                    $user->clinic_name ?? 'N/A',
                    $corporation->name ?? 'BBMP',
                    $constituency->name ?? 'N/A',
                    $ward->name ?? 'N/A',
                    $user->name ?? 'N/A',
                    $user->phone ?? 'N/A',
                    $ins->provider ?? 'N/A',
                    $ins->internet_id ?? 'N/A',
                    $ins->last_recharge_date ? $ins->last_recharge_date->format('d-M-Y') : 'N/A',
                    $ins->recharge_expiry_date ? $ins->recharge_expiry_date->format('d-M-Y') : $ins->expiry_date ?? 'N/A',
                    $ins->plan_validity ?? 'N/A',
                    ucfirst(str_replace('_', ' ', $ins->computed_status)),
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
