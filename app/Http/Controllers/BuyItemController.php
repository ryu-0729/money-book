<?php

namespace App\Http\Controllers;

use App\Models\BuyItem;
use Illuminate\Http\Request;
use App\Repositories\BuyItemRepository; // BuyItemRepositoryを使用
use App\Models\Item;
use App\Http\Requests\StoreBuyItem; // StoreBuyItemバリデーションを利用
use App\Http\Requests\UpdateBuyItem; // UpdateBuyItemバリデーションを利用
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記

class BuyItemController extends Controller
{
    private $buyItemRepository;
    private $item;

    public function __construct(BuyItemRepository $buyItemRepository, Item $item)
    {
        $this->buyItemRepository = $buyItemRepository;
        $this->item = $item;
    }

    public function index()
    {
        $userBuyItems = $this->buyItemRepository->getAll();
        return view('buy_items.index', compact('userBuyItems'));
    }

    public function create()
    {
        $itemsName = $this->item->getAuthUserItems();
        return view('buy_items.create', compact('itemsName'));
    }

    public function store(StoreBuyItem $request)
    {
        $authUser = Auth::user();
        $authUser->buyItems()->create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $this->item->getPrice($request->name, $request->quantity),
            'month' => $request->month,
        ]);

        return redirect()->route('buy_items.index');
    }

    public function show(BuyItem $buyItem)
    {
        $this->authorize($buyItem);
        return view('buy_items.show', compact('buyItem'));
    }

    public function edit(BuyItem $buyItem)
    {
        $this->authorize($buyItem);
        $itemsName = $this->item->getAuthUserItems();
        return view('buy_items.edit', compact('buyItem', 'itemsName'));
    }

    public function update(UpdateBuyItem $request, BuyItem $buyItem)
    {
        $this->authorize($buyItem);
        $buyItem->update([
            'quantity' => $request->quantity,
            'price' => $this->item->getPrice($request->name, $request->quantity),
            'month' => $request->month,
        ]);

        return redirect()->route('buy_items.show', [$buyItem])
            ->with('message', '購入商品を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuyItem  $buyItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyItem $buyItem)
    {
        //
    }
}
