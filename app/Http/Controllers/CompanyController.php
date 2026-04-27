<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show(): JsonResponse
    {
        $company = auth()->user()->company()->with('users')->first();
        return response()->json($company);
    }

    public function update(Request $request): JsonResponse
    {
        $company = auth()->user()->company;

        $data = $request->validate([
            'name'     => 'required|string|max:150',
            'address'  => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:150',
            'website'  => 'nullable|string|max:150',
            'currency' => 'nullable|string|max:10',
        ]);

        $company->update($data);

        return response()->json(['message' => 'Informations mises à jour.', 'company' => $company->fresh()]);
    }

    public function uploadLogo(Request $request): JsonResponse
    {
        $request->validate(['logo' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048']);

        $company = auth()->user()->company;

        if ($company->logo_path) {
            \Storage::disk('public')->delete($company->logo_path);
        }

        $path = $request->file('logo')->store('logos', 'public');
        $company->update(['logo_path' => $path]);

        return response()->json([
            'message'  => 'Logo mis à jour.',
            'logo_url' => asset('storage/' . $path),
        ]);
    }

    public function plans(): JsonResponse
    {
        return response()->json(Company::plans());
    }
}
