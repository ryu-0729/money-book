<?php

namespace App\Http\Controllers;

use App\Models\ItemTag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemTag; // StoreItemTagバリデーションを利用
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記

class ItemTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return void
     */
    public function store(StoreItemTag $request)
    {
        $authUser = Auth::user();
        $itemTag = $authUser->itemTags()->create($request->validated());

        return redirect()->route('item_tags.create')
            ->with('message', $itemTag['tag_name'] . 'を追加しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemTag  $itemTag
     * @return \Illuminate\Http\Response
     */
    public function show(ItemTag $itemTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemTag  $itemTag
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemTag $itemTag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemTag  $itemTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemTag $itemTag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemTag  $itemTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemTag $itemTag)
    {
        //
    }
}
