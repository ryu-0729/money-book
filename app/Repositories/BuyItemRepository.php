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
     * タグ名でのデータ取得も可能
     *
     * @param $month
     * @return array $buyItems
     */
    public function getBuyItemDataSearchMonthAndTagName($month, $tagName = null)
    {
        $buyItems = Auth::user()->buyItems()
            ->select('id', 'name', 'quantity', 'price', 'month', 'item_tag_name', 'updated_at')
            ->sortable()
            ->searchMonthAndTagName($month, $tagName)
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
            ->searchMonthAndTagName($month, $tagName)->get(['price', 'month'])->sum('price');

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

    /**
     * 購入商品の購入月を配列で取得
     * 金額集計ページで使用
     *
     * @return array $buyMonth
     */
    public function getBuyItemMonth()
    {
        $buyItems = Auth::user()->buyItems()->get('month');

        $buyMonth = [0 => ''];
        foreach ($buyItems as $buyItem) {
            $buyMonth[$buyItem->month] = $buyItem->month;
        }
        asort($buyMonth);

        return $buyMonth;
    }
}
