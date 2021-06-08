<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

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
    // 金額集計ページのルート
    Route::get('monies', 'Money')->name('monies');
});
