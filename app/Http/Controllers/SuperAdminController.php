<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\RenewalRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // ── Dashboard
    public function dashboard()
    {
        $stats = [
            'total_companies'  => Company::count(),
            'active_companies' => Company::where('status', 'active')->count(),
            'suspended'        => Company::where('status', 'suspended')->count(),
            'total_users'      => User::where('role', '!=', 'super_admin')->count(),
            'pending_renewals' => RenewalRequest::where('status', 'pending')->count(),
            'plans'            => Company::selectRaw('plan, count(*) as total')
                                    ->groupBy('plan')->pluck('total', 'plan'),
        ];

        $recentCompanies  = Company::latest()->limit(5)->get();
        $pendingRenewals  = RenewalRequest::with('company')->where('status', 'pending')->latest()->limit(5)->get();

        return view('superadmin.dashboard', compact('stats', 'recentCompanies', 'pendingRenewals'));
    }

    // ── Companies list
    public function companies(Request $request)
    {
        $q = Company::withCount('users')->latest();

        if ($search = $request->input('q')) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        }
        if ($plan = $request->input('plan')) {
            $q->where('plan', $plan);
        }
        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }

        $companies = $q->paginate(20)->withQueryString();
        return view('superadmin.companies', compact('companies'));
    }

    // ── Company detail
    public function showCompany(Company $company)
    {
        $company->loadCount('users');
        $users    = $company->users()->orderBy('role')->get();
        $renewals = RenewalRequest::where('company_id', $company->id)->latest()->get();
        return view('superadmin.company-detail', compact('company', 'users', 'renewals'));
    }

    // ── Update company plan / status
    public function updateCompany(Request $request, Company $company)
    {
        $data = $request->validate([
            'plan'             => 'sometimes|in:trial,starter,pro,enterprise',
            'status'           => 'sometimes|in:active,inactive,suspended',
            'plan_expires_at'  => 'sometimes|nullable|date',
            'max_agents'       => 'sometimes|integer|min:1',
        ]);

        if (isset($data['plan'])) {
            $data['max_agents'] = $data['max_agents'] ?? Company::plans()[$data['plan']]['max_agents'];
        }

        $company->update($data);

        return back()->with('success', "Garage «{$company->name}» mis à jour.");
    }

    // ── Renewals list
    public function renewals(Request $request)
    {
        $q = RenewalRequest::with('company')->latest();
        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }
        $renewals = $q->paginate(20)->withQueryString();
        return view('superadmin.renewals', compact('renewals'));
    }

    // ── Approve renewal
    public function approveRenewal(RenewalRequest $renewal)
    {
        if ($renewal->status !== 'pending') {
            return back()->with('error', 'Demande déjà traitée.');
        }

        $company = $renewal->company;
        $base    = ($company->plan_expires_at && $company->plan_expires_at->isFuture())
                    ? $company->plan_expires_at
                    : now();

        $company->update([
            'plan'            => $renewal->plan,
            'plan_expires_at' => $base->addMonths($renewal->duration_months),
            'max_agents'      => Company::plans()[$renewal->plan]['max_agents'],
            'status'          => 'active',
        ]);

        $renewal->update(['status' => 'approved', 'approved_at' => now()]);

        return back()->with('success', "Abonnement approuvé pour «{$company->name}».");
    }

    // ── Reject renewal
    public function rejectRenewal(Request $request, RenewalRequest $renewal)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        $renewal->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->input('reason'),
        ]);

        return back()->with('success', 'Demande rejetée.');
    }
}
