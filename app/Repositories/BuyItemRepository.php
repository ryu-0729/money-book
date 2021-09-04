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
            ->select('id', 'name', 'quantity', 'price', 'month', 'item_tag_name', 'sub_item_tag_name', 'updated_at')
            ->sortable()
            ->latest('updated_at')
            ->paginate(config('paginate.pagination'));

        return $buyItems;
    }

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
            ->select('id', 'name', 'quantity', 'price', 'month', 'item_tag_name', 'sub_item_tag_name', 'updated_at')
            ->sortable()
            ->searchMonthAndTagName($month, $tagName)
            ->latest('updated_at')
            ->paginate(config('paginate.pagination'));

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

    /**
     * 購入商品を昇順または降順で取得する数を決め取得する
     * 取得するカラムの指定可能
     *
     * @param array $col
     * @param string $orderBy
     * @param int $limit
     * @return array $buyItemHistory
     */
    public function getBuyItemHistory(array $col, string $orderBy, int $limit)
    {
        $buyItemHistory = Auth::user()->buyItems()
            ->orderBy('updated_at', $orderBy)
            ->limit($limit)->get($col);

        return $buyItemHistory;
    }

    /**
     * 購入商品を昇順または降順で単一取得する
     * 取得カラムの指定可能
     *
     * @param array $col
     * @param string $orderBy
     * @return void $firstBuyItemHistory
     */
    public function getFirstBuyItemHistory(array $col, string $orderBy)
    {
        $firstBuyItemHistory = Auth::user()->buyItems()
            ->orderBy('updated_at', $orderBy)
            ->firstOrFail($col);

        return $firstBuyItemHistory;
    }
}
