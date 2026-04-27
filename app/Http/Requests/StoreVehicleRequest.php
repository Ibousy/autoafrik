<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function messages(): array
    {
        return [
            'registration.unique' => 'Ce numéro d\'immatriculation existe déjà dans votre garage.',
        ];
    }

    public function rules(): array
    {
        $id        = $this->route('vehicle')?->id;
        $companyId = $this->user()?->company_id;
        return [
            'type'          => 'required|in:garage,rental',
            'brand'         => 'required|string|max:80',
            'model'         => 'required|string|max:80',
            'registration'  => [
                'required', 'string', 'max:20',
                Rule::unique('vehicles', 'registration')
                    ->where('company_id', $companyId)
                    ->ignore($id),
            ],
            'year'          => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'fuel_type'     => 'required|in:essence,diesel,electrique,hybride',
            'transmission'  => 'required|in:manuel,automatique',
            'seats'         => 'required|integer|min:2|max:9',
            'mileage'       => 'required|integer|min:0',
            'price_per_day' => 'nullable|integer|min:0',
            'status'          => 'required|in:available,rented,maintenance,repair',
            'color'           => 'nullable|string|max:50',
            'notes'           => 'nullable|string',
            'owner_name'      => 'nullable|string|max:150',
            'owner_phone'     => 'nullable|string|max:20',
            'owner_phone2'    => 'nullable|string|max:20',
            'owner_email'     => 'nullable|email|max:150',
            'owner_address'   => 'nullable|string|max:255',
            'owner_id_type'   => 'nullable|in:cni,passeport,permis,autre',
            'owner_id_number' => 'nullable|string|max:50',
        ];
    }
}
