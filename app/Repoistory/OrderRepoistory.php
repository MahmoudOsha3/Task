<?php

namespace App\Repoistory ;

use App\Models\Order;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class OrderRepoistory
{
    protected $orderItemRepoistory ;
    public function __construct(OrderItemRepoistory $orderItemRepoistory) {

        $this->orderItemRepoistory = $orderItemRepoistory;
    }

    public function create($data)
    {
        return DB::transaction(function () use ($data){
            $order = Order::create($data) ; // status default 'pending' , (num_order , created_by) createing within observer pattern in model
            $this->orderItemRepoistory->create($order , $data['items']) ;
            return $order ;
        });
    }

public function receiveOrder($request, $order)
{
    DB::beginTransaction();

    try {
        $allReceived = true ; 
        $allReceived = $this->orderItemRepoistory->updateReceiveOrder($request , $order) ;
        $order->update([
            'status' => $allReceived ? 'completed' : 'partial'
        ]);
        DB::commit();
        return true ;

    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}



}


        // foreach ($request->items as $receivedItem) {
        //     $orderItem = $orderItems->where('id', $receivedItem['order_item_id'])->first();

        //     if ($orderItem) {
        //         $qty = $receivedItem['received_quantity'];

        //         $orderItem->increment('received_quantity', $qty);

        //         $orderItem->product->increment('total_stock', $qty);

        //         $stockMovements[] = [
        //             'product_id'   => $orderItem->product_id, 
        //             'user_id'      => auth()->id(),
        //             'order_id'     => $order->id,
        //             'quantity'     => $qty,
        //             'created_at'   => now(),
        //             'updated_at'   => now(),
        //         ];
        //     }
        // }