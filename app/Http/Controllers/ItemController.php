<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Repositories\ItemRepository;
use App\Http\Requests\StoreItem; // StoreItemバリデーションを利用
use App\Http\Requests\UpdateItem; // UpdateItemバリデーションを利用
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記

class ItemController extends Controller
{
    private $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        $userItems = $this->itemRepository->getAll();
        return view('items.index', compact('userItems'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(StoreItem $request)
    {
        $authUser = Auth::user();
        $authUser->items()->create($request->validated());

        return redirect()->route('items.index');
    }

    public function show(Item $item)
    {
        $this->authorize($item);
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $this->authorize($item);
        return view('items.edit', compact('item'));
    }

    public function update(UpdateItem $request, Item $item)
    {
        $this->authorize($item);
        $item->update($request->validated());

        return redirect()->route('items.show', [$item])
            ->with('message', '登録商品を更新しました');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index');
    }
}
