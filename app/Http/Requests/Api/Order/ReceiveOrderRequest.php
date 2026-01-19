<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class ReceiveOrderRequest extends FormRequest
{

    public function authorize()
    {
        return true ;
    }


    public function rules()
    {
        return [
            'items' => 'required|array|min:1' ,
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.received_quantity' => 'required|integer|min:1',
        ];
    }
}
