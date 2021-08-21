<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BuyItemRepository;
use App\Repositories\ItemTagRepository;

class Money extends Controller
{
    private $buyItemRepository;
    private $itemTagRepository;

    public function __construct(BuyItemRepository $buyItemRepository, ItemTagRepository $itemTagRepository)
    {
        $this->buyItemRepository = $buyItemRepository;
        $this->itemTagRepository = $itemTagRepository;
    }

    /**
     * 金額集計ページ
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $buyItemMonth = $this->buyItemRepository->getBuyItemMonth();
        $selectTagNames = $this->itemTagRepository->getTagNames();
        // タグの選択の有無
        if ($request->tagId) {
            $tag = $this->itemTagRepository->getTagNameByRequestTagId($request->tagId);
            $tagName = $tag->tag_name;
        } else {
            $tagName = '';
        }

        $buyItems = $this->buyItemRepository->getBuyItemDataSearchMonthAndTagName($request->month, $tagName);
        $totalPrice = $this->buyItemRepository->getTotalPrice($request->month, $tagName);
        $month = $request->month;

        return view('monies.total', compact('buyItemMonth', 'buyItems', 'totalPrice', 'month', 'selectTagNames', 'tagName'));
    }
}
