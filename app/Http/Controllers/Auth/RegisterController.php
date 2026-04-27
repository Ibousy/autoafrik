<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:150',
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'phone'        => 'nullable|string|max:20',
            'password'     => 'required|string|min:8|confirmed',
        ], [
            'company_name.required' => 'Le nom de l\'entreprise est obligatoire.',
            'name.required'         => 'Votre nom est obligatoire.',
            'email.required'        => 'L\'email est obligatoire.',
            'email.unique'          => 'Cet email est déjà utilisé.',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'    => 'Les mots de passe ne correspondent pas.',
        ]);

        $company = Company::create([
            'name'          => $request->company_name,
            'slug'          => Company::generateSlug($request->company_name),
            'plan'          => 'trial',
            'trial_ends_at' => now()->addDays(14),
            'max_agents'    => 3,
            'status'        => 'active',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => 'owner',
            'is_active'  => true,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('welcome', true);
    }
}
