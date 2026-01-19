<?php

namespace Tests\Feature\Api\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase , WithFaker ;

    public function test_unauthenticated_can_not_create_order() : void
    {
        $response = $this->postJson(route('order.store'), [])->assertStatus(401);
        $this->assertDatabaseEmpty('orders');
    }

    public function test_unauthorize_user_can_not_create_order() : void
    {
        $this->authenticated(['role' => 'receiver']) ; 
        $supplier = $this->createSupplier();
        $product = $this->createProduct();
        $response = $this->postJson(route('order.store'), [
                        'supplier_id' => $supplier->id,
                        'items' => [
                            [
                                'product_id' => $product->id,
                                'requested_quantity' => 30, 
                            ],
                        ],
                    ])->assertStatus(403);
        $response->assertJsonStructure(['message']) ;
    }

    public function test_authorize_user_can_not_create_order_with_invalidate_data_requested_quantity_is_required() : void
    {
        $this->authenticated(['role' => 'purchaser']) ; // authorize
        $supplier = $this->createSupplier();
        $product = $this->createProduct();
        $response = $this->postJson(route('order.store'), [
                        'supplier_id' => $supplier->id,
                        'items' => [
                            [
                                'product_id' => $product->id,
                                'requested_quantity' => null , 
                            ],
                        ],
                    ])->assertStatus(422)
                    ->assertJsonValidationErrors(['items.0.requested_quantity']) ;
    }

    public function test_authorize_user_can_not_create_order_with_invalidate_data_product_id_not_exists_products_table() : void
    {
        $this->authenticated(['role' => 'purchaser']) ; // authorize
        $supplier = $this->createSupplier();
        $product = $this->createProduct();
        $response = $this->postJson(route('order.store'), [
                        'supplier_id' => $supplier->id,
                        'items' => [
                            [
                                'product_id' => 12 ,
                                'requested_quantity' => 30 , 
                            ],
                        ],
                    ])->assertStatus(422)
                    ->assertJsonValidationErrors(['items.0.product_id']) ;
    }


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
