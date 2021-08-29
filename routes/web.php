<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// ログインユーザーのみのルート
Route::middleware(['auth'])->group(function () {
    // Userのリソースルート(create,storeは不要のため取り除く)
    Route::resource('users', 'UserController')->except([
        'create', 'store'
    ]);
    Route::resources([
        // Itemのリソースルート
        'items' => 'ItemController',
        // BuyItemのリソースルート
        'buy_items' => 'BuyItemController',
        // UserGoalのリソースルート
        'user_goals' => 'UserGoalController',
    ]);
    // 複数商品へのタグの選択
    Route::get('item_tags/multiple_tag', 'ItemTagController@multiple')->name('multiple');
    // 複数商品へのタグ更新
    Route::put('item_tags/multiple_tag', 'ItemTagController@multipleTagsUpdate');
    // 商品タグルート(詳細は不要)
    Route::resource('item_tags', 'ItemTagController')->except([
        'show',
    ]);
    // 金額集計ページのルート
    Route::get('monies', 'Money')->name('monies');
    // 最近の購入登録履歴
    Route::get('buy_item_history', 'BuyItemHistory')->name('history');
});
