<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyItem; // BuyItemをインポート
use App\Repositories\BuyItemRepository;
use App\Repositories\ItemTagRepository;

class Money extends Controller
{
    private $buyItem;
    private $buyItemRepository;
    private $itemTagRepository;

    public function __construct(BuyItem $buyItem, BuyItemRepository $buyItemRepository, ItemTagRepository $itemTagRepository)
    {
        $this->buyItem = $buyItem;
        $this->buyItemRepository = $buyItemRepository;
        $this->itemTagRepository = $itemTagRepository;
    }

    public function __invoke(Request $request)
    {
        $buyItemMonth = $this->buyItem->getBuyItemMonth();
        $tagNames = $this->itemTagRepository->getTagNames();
        // タグの選択の有無
        if ($request->tagId) {
            $tag = $this->itemTagRepository->getTagNameByRequestTagId($request->tagId);
            $tagName = $tag->tag_name;
        } else {
            $tagName = '';
        }

        $buyItems = $this->buyItemRepository->getBuyItemDataSearchMonth($request->month, $tagName);
        $totalPrice = $this->buyItemRepository->getTotalPrice($request->month, $tagName);
        $month = $request->month;

        return view('monies.total', compact('buyItemMonth', 'buyItems', 'totalPrice', 'month', 'tagNames', 'tagName'));
    }
}
