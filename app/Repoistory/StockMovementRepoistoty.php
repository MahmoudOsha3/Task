<?php

namespace App\Repoistory ;

use App\Models\StockMovement;

class StockMovementRepoistoty
{
    public function create($stockMovements)
    {
        if (!empty($stockMovements)) {
            StockMovement::insert($stockMovements);
        }
    }
}