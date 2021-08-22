<?php

namespace App\Http\Controllers;

use App\Repositories\BuyItemRepository;
use Illuminate\Http\Request;

class BuyItemHistory extends Controller
{
    private $buyItemRepository;

    public function __construct(BuyItemRepository $buyItemRepository)
    {
        $this->buyItemRepository = $buyItemRepository;
    }

    /**
     * 最近の購入登録履歴ページ
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        // 取得したいカラムの指定
        $col = ['id', 'name', 'quantity', 'price', 'updated_at'];
        $buyItemHistory = $this->buyItemRepository->getBuyItemHistory($col, 'desc', 3);
        $firstBuyItemHistory = $this->buyItemRepository->getFirstBuyItemHistory($col, 'desc');

        return view('buy_items.history', compact('buyItemHistory', 'firstBuyItemHistory'));
    }
}
