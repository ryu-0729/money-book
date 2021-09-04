<?php

namespace App\Http\Controllers;

use App\Models\ItemTag;
use App\Models\BuyItem;
use App\Repositories\ItemTagRepository; // ItemTagRepositoryの利用
use App\Repositories\ItemRepository;
use App\Repositories\BuyItemRepository;
use App\Http\Requests\StoreItemTag; // StoreItemTagバリデーションを利用
use App\Http\Requests\UpdateItemTag; // UpdateItemTagバリデーションを利用
use App\Http\Requests\MultipleItemTag;
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記
use Illuminate\Support\Facades\DB;

class ItemTagController extends Controller
{
    private $itemTagRepository;
    private $itemRepository;
    private $buyItemRepository;

    public function __construct(ItemTagRepository $itemTagRepository, ItemRepository $itemRepository, BuyItemRepository $buyItemRepository)
    {
        $this->itemTagRepository = $itemTagRepository;
        $this->itemRepository = $itemRepository;
        $this->buyItemRepository = $buyItemRepository;
    }

    /**
     * タグ一覧ページ
     * 登録したタグの確認ができる
     */
    public function index()
    {
        $itemTags = $this->itemTagRepository->getAll();
        return view('item_tags.index', compact('itemTags'));
    }

    /**
     * タグ登録ページ
     */
    public function create()
    {
        return view('item_tags.create');
    }

    /**
     * タグ登録
     *
     * @param StoreItemTag $request
     * @return $itemTag
     */
    public function store(StoreItemTag $request)
    {
        $authUser = Auth::user();
        $itemTag = $authUser->itemTags()->create($request->validated());

        return redirect()->route('item_tags.create')
            ->with('message', $itemTag['tag_name'] . 'を追加しました');
    }

    /**
     * タグ編集ページ
     *
     * @param ItemTag $itemTag
     * @return $itemTag
     */
    public function edit(ItemTag $itemTag)
    {
        $this->authorize($itemTag);
        return view('item_tags.edit', compact('itemTag'));
    }

    /**
     * タグ更新処理
     *
     * @param UpdateItemTag $request
     * @param ItemTag $itemTag
     * @return void
     */
    public function update(UpdateItemTag $request, ItemTag $itemTag)
    {
        $this->authorize($itemTag);
        $itemTag->update($request->validated());

        return redirect()->route('item_tags.index')
            ->with('message', $itemTag['tag_name'] . 'を更新しました');
    }

    /**
     * タグ削除処理
     *
     * @param ItemTag $itemTag
     * @return void
     */
    public function destroy(ItemTag $itemTag)
    {
        $this->authorize($itemTag);
        $itemTag->delete();

        return redirect()->route('item_tags.index')
            ->with('message', $itemTag['tag_name'] . 'を削除しました');
    }

    /**
     * 複数商品にタグを適応させるページ
     *
     * @return void
     */
    public function multiple()
    {
        $col = ['id', 'name'];
        $itemTags = $this->itemTagRepository->getTagNames();
        $items = $this->itemRepository->getAllNonPaginate($col);

        return view('item_tags.multiple', compact('itemTags', 'items'));
    }

    /**
     * 選択された商品にタグの登録をする
     *
     * @param MultipleItemTag $request
     * @return void
     */
    public function multipleTagsUpdate(MultipleItemTag $request)
    {
        // タグの特定、タグの選択がない場合はエラーメッセージを返す
        if ($request->tag_id) {
            $tagName = $this->itemTagRepository->getTagNameByRequestTagId($request->tag_id);
        } else {
            return back()->with('error', 'タグの選択がありません');
        }

        try {
            DB::beginTransaction();

            foreach ($request->item as $itemId) {
                // 選択された商品のタグ更新
                $item = $this->itemRepository->getItemByItemId($itemId);
                $item->itemTags()->sync($request->tag_id);

                $buyItems = $this->buyItemRepository->getBuyItemsByItemName($item->name);
                if (!empty($buyItems)) {
                    // 購入商品にも同名の購入商品登録がされていた場合、item_tag_nameの更新をする
                    foreach ($buyItems as $buyItem) {
                        BuyItem::where('id', $buyItem->id)->update([
                            'item_tag_name'     => $tagName->tag_name,
                            'sub_item_tag_name' => null,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return redirect()->route('items.index')->with('message', '複数商品のタグ更新をしました');
    }
}
