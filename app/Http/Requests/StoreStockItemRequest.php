<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('stock_item')?->id;
        return [
            'reference'    => "required|string|max:50|unique:stock_items,reference,{$id}",
            'name'         => 'required|string|max:150',
            'category'     => 'required|in:freinage,moteur,climatisation,pneumatiques,electrique,transmission,carrosserie,echappement,autre',
            'quantity'     => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'unit_price'   => 'required|integer|min:0',
            'supplier'     => 'nullable|string|max:150',
            'notes'        => 'nullable|string',
        ];
    }
}
