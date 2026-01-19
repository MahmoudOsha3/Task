<?php

namespace App\Repoistory ;

use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockServices\StockServices;

class StockMovementRepoistoty
{
    public function create($stockMovements)
    {
        if (!empty($stockMovements)) {
            StockMovement::insert($stockMovements);
        }
    }

    public function find($productId)
    {
        $product = Product::with(['stockMovements' =>function($query){
            $query->with(['order' , 'user']) ; 
        }])->findOrfail($productId) ;
        return $product ;
    }
}