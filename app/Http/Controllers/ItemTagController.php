<?php

namespace App\Http\Controllers;

use App\Models\ItemTag;
use Illuminate\Http\Request;
use App\Repositories\ItemTagRepository; // ItemTagRepositoryの利用
use App\Http\Requests\StoreItemTag; // StoreItemTagバリデーションを利用
use App\Http\Requests\UpdateItemTag; // UpdateItemTagバリデーションを利用
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記

class ItemTagController extends Controller
{
    private $itemTagRepository;

    public function __construct(ItemTagRepository $itemTagRepository)
    {
        $this->itemTagRepository = $itemTagRepository;
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
}
