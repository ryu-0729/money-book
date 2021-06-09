<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyItem; // BuyItemをインポート
use App\Repositories\BuyItemRepository;

class Money extends Controller
{
    private $buyItem;
    private $buyItemRepository;

    public function __construct(BuyItem $buyItem, BuyItemRepository $buyItemRepository)
    {
        $this->buyItem = $buyItem;
        $this->buyItemRepository = $buyItemRepository;
    }

    public function __invoke(Request $request)
    {
        $buyItemMonth = $this->buyItem->getBuyItemMonth();
        $buyItems = $this->buyItemRepository->searchMonth($request->month);
        $totalPrice = $this->buyItemRepository->getTotalPrice($request->month);

        return view('monies.total', compact('buyItemMonth', 'buyItems', 'totalPrice'));
    }
}
