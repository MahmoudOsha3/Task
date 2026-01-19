<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\Order\OrderRequest;
use App\Http\Requests\Api\Order\ReceiveOrderRequest;
use App\Models\Order;
use App\Repoistory\OrderRepoistory;
use App\Traits\ManageApiTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ManageApiTrait ;
    protected $orderRepoistory ;
    public function __construct(OrderRepoistory $orderRepoistory)
    {
        $this->orderRepoistory = $orderRepoistory ;  
    }

    public function store(OrderRequest $request)
    {
        // $this->authorize('create' , Order::class) ;
        $purchaseOrder = $this->orderRepoistory->create($request->validated()) ;
        return $this->createApi($purchaseOrder , 'Order created successfullty') ;
    }

    public function receive(ReceiveOrderRequest $request , Order $order)
    {
        // $this->authorize('recieve', Order::class) ;
        $receiveOrder = $this->orderRepoistory->receiveOrder($request->validated() , $order);
        return $this->successApi($receiveOrder ,'Order received successfully') ;
    }

}
