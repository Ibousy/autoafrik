<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepairRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'vehicle_id'     => 'required|exists:vehicles,id',
            'client_id'      => 'required|exists:clients,id',
            'employee_id'    => 'nullable|exists:employees,id',
            'type'           => 'required|in:reparation,maintenance',
            'status'         => 'required|in:pending,in_progress,done',
            'priority'       => 'required|in:normal,high,urgent',
            'description'    => 'required|string',
            'diagnosis'      => 'nullable|string',
            'labor_cost'     => 'required|integer|min:0',
            'payment_status' => 'required|in:paid,pending,partial',
            'entered_at'     => 'required|date',
            'completed_at'   => 'nullable|date|after_or_equal:entered_at',
        ];
    }
}
