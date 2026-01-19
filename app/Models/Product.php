<?php

namespace App\Models ;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'total_stock'] ;


    public function stockMovements()
{
    return $this->hasMany(StockMovement::class , 'product_id') ;
}
}
