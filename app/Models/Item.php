<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記
use Kyslik\ColumnSortable\Sortable; // ソート機能

class Item extends Model
{
    use Sortable;

    protected $fillable = [
        'name', 'price'
    ];

    // ソートするカラムの設定
    public $sortable = [
        'name', 'price',
    ];

    // Userモデルとのリレーション
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // ユーザーが登録した商品の名前を配列で取得
    public function getAuthUserItems()
    {
        $items = Auth::user()->items()->get('name');

        $itemsName = [];

        foreach ($items as $name) {
            $itemsName[$name->name] = $name->name;
        }

        return $itemsName;
    }

    // リクエストされた個数から金額を計算する処理
    public function getPrice($name, $quantity)
    {
        $getPrice = Auth::user()->items()->where('name', $name)
            ->firstOrFail();

        $price = $getPrice->price * $quantity;

        return $price;
    }
}
