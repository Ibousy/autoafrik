<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'type'        => 'required|in:revenue,expense',
            'category'    => 'required|in:reparation,location,salaires,fournitures,charges,achat_pieces,autre',
            'amount'      => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'date'        => 'required|date',
        ];
    }
}
