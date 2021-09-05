<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\BuyItem;
use App\Repositories\ItemRepository;
use App\Repositories\ItemTagRepository; // ItemTagRepositoryの利用
use App\Repositories\BuyItemRepository;
use App\Http\Requests\StoreItem; // StoreItemバリデーションを利用
use App\Http\Requests\UpdateItem; // UpdateItemバリデーションを利用
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    private $itemRepository;
    private $itemTagRepository;
    private $buyItemRepository;

    const NOT_REQUEST = '0';

    public function __construct(ItemRepository $itemRepository, ItemTagRepository $itemTagRepository, BuyItemRepository $buyItemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->itemTagRepository = $itemTagRepository;
        $this->buyItemRepository = $buyItemRepository;
    }

    /**
     * 登録商品一覧ページ
     *
     * @return void
     */
    public function index()
    {
        $userItems = $this->itemRepository->getAll();
        return view('items.index', compact('userItems'));
    }

    /**
     * 商品登録ページ
     * ユーザーに紐づくタグを取得し、タグ名を配列にして返す
     *
     * @return $tagName
     */
    public function create()
    {
        // ユーザーに紐づくタグの取得
        $tagName = $this->itemTagRepository->getTagNames();

        return view('items.create', compact('tagName'));
    }

    /**
     * 商品登録
     * タグが選択されていた場合には中間テーブルへのデータ登録
     *
     * @param StoreItem $request
     * @return void
     * @throws Exception
     */
    public function store(StoreItem $request)
    {
        $authUser = Auth::user();

        try {
            DB::beginTransaction();
            $item = $authUser->items()->create($request->validated());

            if ($request->tagId !== self::NOT_REQUEST && $request->subTagId !== self::NOT_REQUEST) {
                // 商品タグとサブタグが選択されている場合
                $item->itemTags()->sync([$request->tagId, $request->subTagId]);
            } elseif ($request->tagId !== self::NOT_REQUEST) {
                // 商品タグのみのが選択
                $item->itemTags()->sync($request->tagId);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return redirect()->route('items.create')
            ->with('message', $item['name'] . 'を商品登録しました');
    }

    /**
     * 登録商品詳細
     *
     * @param Item $item
     * @return void
     */
    public function show(Item $item)
    {
        $this->authorize($item);
        return view('items.show', compact('item'));
    }

    /**
     * 登録商品更新ページ
     *
     * @param Item $item
     * @return void
     */
    public function edit(Item $item)
    {
        $this->authorize($item);
        // ユーザーに紐づくタグの取得
        $tagName = $this->itemTagRepository->getTagNames();

        return view('items.edit', compact('item', 'tagName'));
    }

    /**
     * 登録商品更新処理
     *
     * @param UpdateItem $request
     * @param Item $item
     * @return void
     * @throws Exception
     */
    public function update(UpdateItem $request, Item $item)
    {
        $this->authorize($item);

        // 更新する商品と同名の購入商品のデータ取得
        $buyItems = $this->buyItemRepository->getBuyItemsByItemName($item->name);
        // タグ名の取得
        if ($request->tagId !== self::NOT_REQUEST) {
            $tagName = $this->itemTagRepository->getTagNameByRequestTagId($request->tagId);
        }
        // サブタグ名の取得
        if ($request->subTagId !== self::NOT_REQUEST) {
            $subTagName = $this->itemTagRepository->getTagNameByRequestTagId($request->subTagId);
        }

        try {
            DB::beginTransaction();
            $item->update($request->validated());

            if ($request->tagId !== self::NOT_REQUEST && $request->subTagId !== self::NOT_REQUEST) {
                // 商品タグとサブタグ両方の登録
                $item->itemTags()->sync([$request->tagId, $request->subTagId]);
            } elseif ($request->tagId !== self::NOT_REQUEST) {
                // 商品タグのみの登録
                $item->itemTags()->sync($request->tagId);
            }

            if (!empty($buyItems) && (!empty($tagName) && !empty($subTagName))) {
                // 購入商品名とタグの更新がある場合（サブタグも含む）
                foreach ($buyItems as $buyItem) {
                    BuyItem::where('id', $buyItem->id)->update([
                        'name'              => $request->name,
                        'item_tag_name'     => $tagName->tag_name,
                        'sub_item_tag_name' => $subTagName->tag_name,
                    ]);
                }
            } elseif (!empty($buyItems) && !empty($tagName)) {
                // 購入商品名と商品タグの更新
                foreach ($buyItems as $buyItem) {
                    BuyItem::where('id', $buyItem->id)->update([
                        'name'          => $request->name,
                        'item_tag_name' => $tagName->tag_name,
                    ]);
                }
            } elseif (!empty($buyItems)) {
                // 商品名のみ更新の場合
                foreach ($buyItems as $buyItem) {
                    BuyItem::where('id', $buyItem->id)->update([
                        'name' => $request->name,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return redirect()->route('items.show', [$item])
            ->with('message', '登録商品を更新しました');
    }

    /**
     * todo 削除する際、購入商品で同名の商品を削除するか検討
     * 登録商品削除
     *
     * @param Item $item
     * @return void
     */
    public function destroy(Item $item)
    {
        $this->authorize($item);
        $item->delete();
        return redirect()->route('items.index')
            ->with('message', $item['name'] . 'を削除しました');
    }
}
