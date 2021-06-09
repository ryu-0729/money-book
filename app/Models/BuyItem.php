<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記

class BuyItem extends Model
{
    protected $fillable = [
        'name', 'quantity', 'price', 'month',
    ];

    // Userモデルとのリレーション
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // ユーザーが登録した購入商品の月を配列で取得
    public function getBuyItemMonth()
    {
        $buyItems = Auth::user()->buyItems()->get('month');

        $buyItemMonth = [];

        foreach ($buyItems as $month) {
            $buyItemMonth[$month->month] = $month->month;
        }

        return $buyItemMonth;
    }

    // リクエストされた月からデータを絞り込むクエリスコープ
    public function scopeSearchMonth($query, $month)
    {
        if ($month) {
            return $query->where('month', $month);
        }
    }
}
