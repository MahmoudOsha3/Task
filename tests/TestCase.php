<?php

namespace Tests;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication , RefreshDatabase , WithFaker ;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function createUser(array $attributes = [])
    {
        return User::factory()->create($attributes) ;
    }

    public function createSupplier(array $attributes = [])
    {
        return Supplier::factory()->create($attributes) ;
    }

    public function createProduct(array $attributes = [])
    {
        return Product::factory()->create($attributes) ;
    }


    public function authenticated(array $attributes = [])
    {
        $user = $this->createUser($attributes);
        return $this->actingAs($user , 'sanctum') ;
    }
}
