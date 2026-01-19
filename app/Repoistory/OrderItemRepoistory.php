<?php

namespace App\Repoistory ;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderItemRepoistory
{

    public function create($order , $orderItems)
    {
        $items = [] ; // bulk insert reather than queries inside loop  (only one query)
        foreach ($orderItems as $item) {
            $items[] = [
                'order_id' => $order->id,
                'product_id' => $item['product_id'] ,
                'requested_quantity' => $item['requested_quantity'] , // received_quantity => default 0
                'created_at' => now() ,
                'updated_at'=> now() ,
            ] ;
        }
        OrderItem::insert($items);
    }


}