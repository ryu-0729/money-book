<?php

namespace App\Http\Controllers;

use App\Models\BuyItem;
use App\Repositories\BuyItemRepository; // BuyItemRepositoryを使用
use App\Repositories\ItemRepository; // ItemRepositoryを利用
use App\Models\Item;
use App\Http\Requests\StoreBuyItem; // StoreBuyItemバリデーションを利用
use App\Http\Requests\UpdateBuyItem; // UpdateBuyItemバリデーションを利用
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記

class BuyItemController extends Controller
{
    private $buyItemRepository;
    private $item;
    private $itemRepository;

    public function __construct(BuyItemRepository $buyItemRepository, Item $item, ItemRepository $itemRepository)
    {
        $this->buyItemRepository = $buyItemRepository;
        $this->item = $item;
        $this->itemRepository = $itemRepository;
    }

    /**
     * 購入商品一覧
     *
     * @return void
     */
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

    /**
     * 購入商品の登録
     *
     * @param StoreBuyItem $request
     * @return void
     */
    public function store(StoreBuyItem $request)
    {
        $authUser = Auth::user();

        // 購入商品と同名の商品タグ名を取得
        $tagName = $this->itemRepository->getItemTagNameByBuyItemName($request->name);
        // タグが存在しない場合はnullで登録する
        if (empty($tagName)) {
            $tagName = null;
        }

        $buyItem = $authUser->buyItems()->create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $this->item->getPrice($request->name, $request->quantity),
            'month' => $request->month,
            'item_tag_name' => $tagName,
        ]);

        return redirect()->route('buy_items.create')
            ->with('message', $buyItem['name'] . 'を購入しました');
    }

    /**
     * 購入商品詳細ページ
     *
     * @param BuyItem $buyItem
     * @return void
     */
    public function show(BuyItem $buyItem)
    {
        $this->authorize($buyItem);
        return view('buy_items.show', compact('buyItem'));
    }

    /**
     * 購入商品編集ページ
     *
     * @param BuyItem $buyItem
     * @return void
     */
    public function edit(BuyItem $buyItem)
    {
        $this->authorize($buyItem);
        $itemsName = $this->item->getAuthUserItems();
        return view('buy_items.edit', compact('buyItem', 'itemsName'));
    }

    /**
     * 購入商品の更新
     *
     * @param UpdateBuyItem $request
     * @param BuyItem $buyItem
     * @return void
     */
    public function update(UpdateBuyItem $request, BuyItem $buyItem)
    {
        $this->authorize($buyItem);
        // 購入商品と同名の商品タグ名を取得
        $tagName = $this->itemRepository->getItemTagNameByBuyItemName($request->name);
        // タグが存在しない場合はnullで更新する
        if (empty($tagName)) {
            $tagName = null;
        }

        $buyItem->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $this->item->getPrice($request->name, $request->quantity),
            'month' => $request->month,
            'item_tag_name' => $tagName
        ]);

        return redirect()->route('buy_items.show', [$buyItem])
            ->with('message', '購入商品を更新しました');
    }

    /**
     * 購入商品削除
     *
     * @param BuyItem $buyItem
     * @return void
     */
    public function destroy(BuyItem $buyItem)
    {
        $this->authorize($buyItem);
        $buyItem->delete();
        return redirect()->route('buy_items.index');
    }
}
