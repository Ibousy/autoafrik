<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'vehicle_id'     => 'required|exists:vehicles,id',
            'client_id'      => 'required|exists:clients,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after:start_date',
            'price_per_day'  => 'required|integer|min:0',
            'total_price'    => 'required|integer|min:0',
            'status'         => 'required|in:active,completed,cancelled',
            'payment_status' => 'required|in:paid,pending,partial',
            'payment_method' => 'required|in:especes,virement,mobile_money',
            'notes'          => 'nullable|string',
        ];
    }
}
