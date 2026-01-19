<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{

    public function definition()
    {
        return [
            'order_id' => $this->faker->randomDigit  ,
            'product_id' => $this->faker->randomDigit ,
            'requested_quantity' => 100 ,
            'received_quantity' => 0
        ];
    }
}


