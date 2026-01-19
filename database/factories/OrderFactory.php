<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_number' => '20260001' , 
            'supplier_id' => $this->faker->randomDigit , 
            'created_by' => $this->faker->randomDigit , 
            'status' => 'pending'
            ];
    }
}


