<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    // Userのリソースルート(create,storeは不要のため取り除く)
    Route::resource('users', 'UserController')->except([
        'create', 'store'
    ]);
});


// Itemのリソースルート
Route::resource('items', 'ItemController');
// BuyItemのリソースルート
Route::resource('buy_items', 'BuyItemController');
// UserGoalのリソースルート
Route::resource('user_goals', 'UserGoalController');
