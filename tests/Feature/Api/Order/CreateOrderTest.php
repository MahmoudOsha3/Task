<?php

namespace Tests\Feature\Api\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase ;

    public function test_purchaser_can_create_order()
    {
        $this->authenticated(['role' => 'purchaser']) ; 
        $supplier = $this->createSupplier();
        $product_1 = $this->createProduct();
        $product_2 = $this->createProduct();

        $payload = [
            'supplier_id' => $supplier->id,
            'items' => [
                [
                    'product_id' => $product_1->id,
                    'requested_quantity' => 30, 
                ],
                [
                    'product_id' => $product_2->id,
                    'requested_quantity' => 100 , 
                ]
            ],
        ];
        $res = $this->postJson(route('order.store'), $payload) ;

        $res->assertStatus(201);
        $this->assertDatabaseHas('orders', ['supplier_id' => $supplier->id]);
    }
}
