<?php

namespace App\Repoistory ;

use App\Models\Order;
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


}