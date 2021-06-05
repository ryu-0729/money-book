<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ItemRepository implements RepositoryInterface
{
    public function getAll()
    {
        $items = Auth::user()->items()
            ->select('id', 'name', 'price')->paginate(20);
        return $items;
    }
}