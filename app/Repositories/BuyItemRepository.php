<?php

namespace App\Repositories;

use App\Models\BuyItem; // BuyItemをインポート
use Illuminate\Support\Facades\Auth;

class BuyItemRepository implements RepositoryInterface
{
    public function getAll()
    {
        $buyItems = Auth::user()->buyItems()
            ->select('id', 'name', 'quantity', 'price', 'month', 'updated_at')
            ->sortable()
            ->latest('updated_at')
            ->paginate(20);

        return $buyItems;
    }

    // 
    /**
     * 検索月からその月のデータの取得
     *
     * @param $month
     * @return array $buyItems
     */
    public function getBuyItemDataSearchMonth($month)
    {
        $buyItems = Auth::user()->buyItems()
            ->select('id', 'name', 'quantity', 'price', 'month', 'updated_at')
            ->sortable()
            ->searchMonth($month)
            ->latest('updated_at')
            ->paginate(20);

        return $buyItems;
    }

    // 検索月からその月の合計金額を取得
    public function getTotalPrice($month)
    {
        $price = Auth::user()->buyItems()
            ->searchMonth($month)->get(['price', 'month'])->sum('price');

        return $price;
    }
}
