<?php

namespace App\Repositories;

use App\Models\BuyItem;
use Illuminate\Support\Facades\Auth;

class BuyItemRepository implements RepositoryInterface
{
    public function getAll()
    {
        $buyItems = Auth::user()->buyItems()
            ->select('id', 'name', 'quantity', 'price', 'month')
            ->paginate(20);

        return $buyItems;
    }
}