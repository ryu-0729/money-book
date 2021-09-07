<?php

namespace App\Http\Controllers;

use App\Models\BuyItem;
use App\Repositories\BuyItemRepository; // BuyItemRepositoryを使用
use App\Repositories\ItemRepository; // ItemRepositoryを利用
use App\Http\Requests\StoreBuyItem; // StoreBuyItemバリデーションを利用
use App\Http\Requests\UpdateBuyItem; // UpdateBuyItemバリデーションを利用
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記

class BuyItemController extends Controller
{
    private $buyItemRepository;
    private $itemRepository;

    public function __construct(BuyItemRepository $buyItemRepository, ItemRepository $itemRepository)
    {
        $this->buyItemRepository = $buyItemRepository;
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

    /**
     * 購入商品登録ページ
     *
     * @return void
     */
    public function create()
    {
        $itemsName = $this->itemRepository->getAuthUserItems();
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

        // 購入商品と同名の商品タグ名を配列で取得
        $tagNames = $this->itemRepository->getItemTagNameByBuyItemName($request->name);

        if (!empty($tagNames[0]) && !empty($tagNames[1])) {
            // タグとサブタグの両方がある場合
            if ($request->price) {
                // 金額の入力がある場合
                $buyItem = $authUser->buyItems()->create([
                    'name'              => $request->name,
                    'quantity'          => $request->quantity,
                    'price'             => $request->price,
                    'month'             => $request->month,
                    'item_tag_name'     => $tagNames[0],
                    'sub_item_tag_name' => $tagNames[1],
                ]);
            } else {
                $buyItem = $authUser->buyItems()->create([
                    'name'              => $request->name,
                    'quantity'          => $request->quantity,
                    'price'             => $this->itemRepository->getPrice($request->name, $request->quantity),
                    'month'             => $request->month,
                    'item_tag_name'     => $tagNames[0],
                    'sub_item_tag_name' => $tagNames[1],
                ]);
            }
        } elseif (!empty($tagNames[0])) {
            // タグのみがある場合
            if ($request->price) {
                // 金額入力あり
                $buyItem = $authUser->buyItems()->create([
                    'name'          => $request->name,
                    'quantity'      => $request->quantity,
                    'price'         => $request->price,
                    'month'         => $request->month,
                    'item_tag_name' => $tagNames[0],
                ]);
            } else {
                $buyItem = $authUser->buyItems()->create([
                    'name'          => $request->name,
                    'quantity'      => $request->quantity,
                    'price'         => $this->itemRepository->getPrice($request->name, $request->quantity),
                    'month'         => $request->month,
                    'item_tag_name' => $tagNames[0],
                ]);
            }
        } else {
            if ($request->price) {
                // 金額入力がある
                $buyItem = $authUser->buyItems()->create([
                    'name'     => $request->name,
                    'quantity' => $request->quantity,
                    'price'    => $request->price,
                    'month'    => $request->month,
                ]);
            } else {
                $buyItem = $authUser->buyItems()->create([
                    'name'     => $request->name,
                    'quantity' => $request->quantity,
                    'price'    => $this->itemRepository->getPrice($request->name, $request->quantity),
                    'month'    => $request->month,
                ]);
            }
        }

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
        $itemsName = $this->itemRepository->getAuthUserItems();

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
        // 購入商品と同名の商品タグ名を配列で取得
        $tagNames = $this->itemRepository->getItemTagNameByBuyItemName($request->name);

        if (!empty($tagNames[0]) && !empty($tagNames[1])) {
            // タグとサブタグの両方がある場合
            if ($buyItem->price === ((int)$request->price)) {
                // 金額の入力なし
                $buyItem->update([
                    'name'              => $request->name,
                    'quantity'          => $request->quantity,
                    'price'             => $this->itemRepository->getPrice($request->name, $request->quantity),
                    'month'             => $request->month,
                    'item_tag_name'     => $tagNames[0],
                    'sub_item_tag_name' => $tagNames[1],
                ]);
            } else {
                // 金額の入力あり
                $buyItem->update([
                    'name'              => $request->name,
                    'quantity'          => $request->quantity,
                    'price'             => $request->price,
                    'month'             => $request->month,
                    'item_tag_name'     => $tagNames[0],
                    'sub_item_tag_name' => $tagNames[1],
                ]);
            }
        } elseif (!empty($tagNames[0])) {
            // タグのみがある場合
            if ($buyItem->price === ((int)$request->price)) {
                // 金額の入力なし
                $buyItem->update([
                    'name'              => $request->name,
                    'quantity'          => $request->quantity,
                    'price'             => $this->itemRepository->getPrice($request->name, $request->quantity),
                    'month'             => $request->month,
                    'item_tag_name'     => $tagNames[0],
                    'sub_item_tag_name' => null,
                ]);
            } else {
                // 金額の入力あり
                $buyItem->update([
                    'name'              => $request->name,
                    'quantity'          => $request->quantity,
                    'price'             => $request->price,
                    'month'             => $request->month,
                    'item_tag_name'     => $tagNames[0],
                    'sub_item_tag_name' => null,
                ]);
            }
        } else {
            // タグなしの場合
            if ($buyItem->price === ((int)$request->price)) {
                // 金額の入力なし
                $buyItem->update([
                    'name'     => $request->name,
                    'quantity' => $request->quantity,
                    'price'    => $this->itemRepository->getPrice($request->name, $request->quantity),
                    'month'    => $request->month,
                ]);
            } else {
                // 金額の入力あり
                $buyItem->update([
                    'name'     => $request->name,
                    'quantity' => $request->quantity,
                    'price'    => $request->price,
                    'month'    => $request->month,
                ]);
            }
        }

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
        return redirect()->route('buy_items.index')
            ->with('message', $buyItem['name'] . 'を削除しました');
    }
}
