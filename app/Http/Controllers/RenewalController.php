<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\RenewalRequest;
use Illuminate\Http\Request;

class RenewalController extends Controller
{
    public function show(Request $request)
    {
        /** @var \App\Models\User $me */
        $me      = $request->user();
        $company = $me->company;

        if (!$company) abort(404);

        $pending  = RenewalRequest::where('company_id', $company->id)
                        ->where('status', 'pending')->exists();
        $history  = RenewalRequest::where('company_id', $company->id)
                        ->latest()->limit(5)->get();
        $plans    = Company::plans();

        return view('renewal.show', compact('company', 'pending', 'history', 'plans'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $me */
        $me = $request->user();

        if (!in_array($me->role, ['owner', 'admin'])) {
            abort(403, 'Seul le propriétaire ou l\'admin peut soumettre une demande.');
        }

        $data = $request->validate([
            'plan'            => 'required|in:starter,pro,enterprise',
            'duration_months' => 'required|integer|in:1,3,6,12',
        ]);

        if (RenewalRequest::where('company_id', $me->company_id)
                ->where('status', 'pending')->exists()) {
            return back()->with('error', 'Une demande est déjà en attente.');
        }

        RenewalRequest::create([
            'company_id'      => $me->company_id,
            'plan'            => $data['plan'],
            'duration_months' => $data['duration_months'],
            'amount'          => RenewalRequest::priceFor($data['plan'], (int)$data['duration_months']),
            'status'          => 'pending',
        ]);

        return back()->with('success', 'Demande de renouvellement envoyée. Le super admin va valider.');
    }
}
