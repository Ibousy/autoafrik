<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'role'       => 'required|in:chef_mecanicien,mecanicien_senior,mecanicien,electricien,magasinier,receptionniste,gerant,comptable',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|max:150',
            'salary'     => 'required|integer|min:0',
            'hired_at'   => 'required|date',
            'status'     => 'required|in:active,inactive,on_leave',
        ];
    }
}
