<?php

namespace App\Models ;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['order_number' , 'supplier_id' , 'created_by' , 'status'] ;

    public static function booted()
    {
        static::creating(function (Order $order) {
            $order->order_number = Order::getNextNumberOrder() ;
            $order->created_by = auth()->id() ;
        });
    }

    public static function getNextNumberOrder()
    {
        $year = Carbon::now()->year ;
        $latest_order = Order::whereYear('created_at' , $year )->max('order_number') ;
        if($latest_order){
            return $latest_order + 1 ;
        }
        return $year . '0001' ;
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    

}
