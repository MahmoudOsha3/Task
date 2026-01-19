<?php

namespace App\Http\Requests\Api\Order ;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize()
    {
        return true ;
    }

    public function rules()
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id' ,
            'items' => 'required|array|min:1' ,
            'items.*.product_id' => 'required|exists:products,id' ,
            'items.*.requested_quantity' => 'required|integer|min:1',
        ];
    }
}
