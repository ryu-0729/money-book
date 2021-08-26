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
            ->paginate(20);
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

        $tagName = '';
        // $itemDataから一致するタグの取得
        for ($i = 0; $i < count($itemData); $i++) {
            $searchItemName = array_flip($itemData[$i]);
            $tagName = array_search($buyItemName, $searchItemName, true);

            if (!empty($tagName)) {
                break;
            }
        }

        return $tagName;
    }
}
