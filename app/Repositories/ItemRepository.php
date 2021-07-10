<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemRepository implements RepositoryInterface
{
    public function getAll()
    {
        $items = Auth::user()->items()
            ->select('id', 'name', 'price', 'updated_at')
            ->sortable()
            ->latest('updated_at')
            ->paginate(20);
        return $items;
    }
}