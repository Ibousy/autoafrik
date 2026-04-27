<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('client')?->id;
        return [
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => "nullable|email|unique:clients,email,{$id}",
            'phone'         => 'required|string|max:20',
            'phone2'        => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'nationality'   => 'nullable|string|max:100',
            'profession'    => 'nullable|string|max:150',
            'date_of_birth' => 'nullable|date',
            'id_type'       => 'nullable|in:cni,passeport,permis,autre',
            'id_number'     => 'nullable|string|max:50',
            'type'          => 'required|in:particulier,entreprise',
            'company_name'  => 'nullable|string|max:150',
            'notes'         => 'nullable|string',
        ];
    }
}
