<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StockMovementResource;
use App\Models\Product;
use App\Models\StockMovement;
use App\Repoistory\StockMovementRepoistoty;
use App\Services\StockServices\StockServices;
use App\Traits\ManageApiTrait;
use Illuminate\Http\Request;

class StockController extends Controller
{
    use ManageApiTrait;
    protected $stockMovementRepoistoty ;
    public function __construct(StockMovementRepoistoty $stockMovementRepoistoty) {
        $this->stockMovementRepoistoty = $stockMovementRepoistoty ;
    }

    public function getProductStockDetails($productId)
    {
        $this->authorize('view' , StockMovement::class );
        $product = $this->stockMovementRepoistoty->find($productId);
        $history = StockServices::ProductHistory($product) ;
        
        return $this->successApi([
                'product_name'        => $product->name,
                'current_total_stock' => $product->total_stock,
                'history'             => $history,
            ], 'Product fetched successfully');
    }
}
