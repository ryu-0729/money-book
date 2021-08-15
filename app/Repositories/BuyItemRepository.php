<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class BuyItemRepository implements RepositoryInterface
{
    /**
     * ユーザーに紐づく購入商品の取得
     *
     * @return void
     */
    public function getAll()
    {
        $buyItems = Auth::user()->buyItems()
            ->select('id', 'name', 'quantity', 'price', 'month', 'item_tag_name', 'updated_at')
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
    public function getBuyItemDataSearchMonth($month, $tagName = null)
    {
        $buyItems = Auth::user()->buyItems()
            ->select('id', 'name', 'quantity', 'price', 'month', 'item_tag_name', 'updated_at')
            ->sortable()
            ->searchMonth($month, $tagName)
            ->latest('updated_at')
            ->paginate(20);

        return $buyItems;
    }

    /**
     * 検索月からその月の合計金額を取得
     *
     * @param [type] $month
     * @param [type] $tagName
     * @return void
     */
    public function getTotalPrice($month, $tagName = null)
    {
        $price = Auth::user()->buyItems()
            ->searchMonth($month, $tagName)->get(['price', 'month'])->sum('price');

        return $price;
    }

    /**
     * 登録商品名から購入商品のデータ取得
     *
     * @param string $itemName
     * @return array $buyItems
     */
    public function getBuyItemsByItemName(string $itemName)
    {
        $buyItems = Auth::user()->buyItems()
            ->where('name', $itemName)
            ->get(['id', 'name']);

        return $buyItems;
    }
}
