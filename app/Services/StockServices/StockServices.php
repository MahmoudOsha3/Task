<?php

namespace App\Services\StockServices;

class StockServices
{
    public static function ProductHistory($product)
    {
        $history = $product->stockMovements->map(function ($movement) {
            return [
                'order_number' => $movement->order?->order_number,
                'quantity'     => $movement->quantity,
                'received_by'  => $movement->user?->name,
                'date'         => $movement->created_at,
            ];
        });
        return $history ;   
    }
}