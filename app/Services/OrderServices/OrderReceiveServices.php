<?php

namespace App\Services\OrderServices;

class OrderReceiveServices
{
    public static function checkOrderItem($orderItem , $itemData)
    {
        if (!$orderItem) {
            throw new \Exception("Order Item ID {$itemData['order_item_id']} not found in order" );
        }
    }

    public static function orderReceivedPartialOrCompleted($orderItem)
    {
        $status = true ; // completed
        if ($orderItem->received_quantity < $orderItem->requested_quantity) {
            $status = false ; // partial
        }
        return $status ;
    }
}