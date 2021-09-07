<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class ItemRepository implements RepositoryInterface
{
    /**
     * ユーザーに紐づく商品の取得
     *
     * @return void
     */
    public function getAll()
    {
        $items = Auth::user()->items()
            ->select('id', 'name', 'price', 'updated_at')
            ->sortable()
            ->latest('updated_at')
            ->paginate(config('paginate.pagination'));

        return $items;
    }

    /**
     * ユーザーに紐づく商品の取得
     * ページネーションの指定はなし
     *
     * @param $col
     * @return void
     */
    public function getAllNonPaginate($col)
    {
        $items = Auth::user()->items()
            ->get($col);

        return $items;
    }

    /**
     * 購入商品と同じ商品名のタグを取得
     * 購入商品登録、更新で使用
     *
     * @param string $buyItemName
     * @return void
     */
    public function getItemTagNameByBuyItemName(string $buyItemName)
    {
        // ユーザーの登録した商品の取得
        $userItems = $this->getAll();

        $itemData = [];
        foreach ($userItems as $item) {
            foreach ($item->itemTags as $tag) {
                // 商品名をキーとしてタグの取得
                $itemData[] = [$item->name => $tag->tag_name];
            }
        }

        $tagNames = [];
        // $itemDataから一致するタグの取得
        for ($i = 0; $i < count($itemData); $i++) {
            $searchItemName = array_flip($itemData[$i]);
            $tagName = array_search($buyItemName, $searchItemName, true);

            if (!empty($tagName)) {
                $tagNames[] = $tagName;
            }
        }

        return $tagNames;
    }

    /**
     * 商品IDから商品の取得
     *
     * @param integer $itemId
     * @return void
     */
    public function getItemByItemId(int $itemId)
    {
        $item = Auth::user()->items()
            ->where('id', $itemId)
            ->firstOrFail();

        return $item;
    }

    /**
     * ユーザーが登録した商品の名前を配列で取得
     * Models/Itemから移管
     *
     * @return void
     */
    public function getAuthUserItems()
    {
        $items = $this->getAllNonPaginate('name');

        $itemsName = [];

        foreach ($items as $item) {
            $itemsName[$item->name] = $item->name;
        }

        return $itemsName;
    }

    /**
     * 購入商品登録、更新で金額を計算する
     * Models/Itemから移管
     *
     * @param $name
     * @param $quantity
     * @return void
     */
    public function getPrice($name, $quantity)
    {
        $getItemPrice = Auth::user()->items()->where('name', $name)
            ->firstOrFail('price');

        $price = $getItemPrice->price * $quantity;

        return $price;
    }
}
