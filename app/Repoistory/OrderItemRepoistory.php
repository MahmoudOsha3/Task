<?php

namespace App\Repoistory ;

use App\Models\OrderItem;
use App\Services\OrderServices\OrderReceiveServices;


class OrderItemRepoistory
{
    protected $stockMovementsRepo;
    public function __construct(StockMovementRepoistoty $stockMovementsRepo)
    {
        $this->stockMovementsRepo = $stockMovementsRepo ;
    }


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

    public function updateReceiveOrder($request , $order)
    {
        $stockMovements = [] ;
        $statusOrder = true ;

        $orderItems = $order->items()->with('product')->get();
        foreach ($request['items'] as $itemData) {
            $orderItem = $orderItems->where('id', $itemData['order_item_id'])->first();
            OrderReceiveServices::checkOrderItem($orderItem , $itemData) ;

            $orderItem->increment('received_quantity', $itemData['received_quantity']);
            $orderItem->product->increment('total_stock', $itemData['received_quantity']);

            $stockMovements[] = [
                'product_id' => $orderItem->product_id,
                'user_id'    => auth()->id(),
                'order_id'   => $orderItem->order_id,
                'quantity'   => $itemData['received_quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $statusOrder = OrderReceiveServices::orderReceivedPartialOrCompleted($orderItem) ;
        }
        $this->stockMovementsRepo->create($stockMovements) ;
        return $statusOrder ;
    }


}