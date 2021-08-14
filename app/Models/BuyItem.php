<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記
use Kyslik\ColumnSortable\Sortable; // ソート機能

class BuyItem extends Model
{
    use Sortable;

    /**
     * buy_itemsテーブルと関連
     *
     * @var string
     */
    protected $table = 'buy_items';

    /**
     * buy_itemsテーブルの主キー
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 複数代入許可カラム
     *
     * @var array
     */
    protected $fillable = [
        'name', 'quantity', 'price', 'month', 'item_tag_name'
    ];

    /**
     * ソート許可カラム
     *
     * @var array
     */
    public $sortable = [
        'name', 'quantity', 'price', 'month',
    ];

    /**
     * ユーザーモデルとのリレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * ユーザーが登録した購入商品の月を配列で取得
     *
     * @return void
     */
    public function getBuyItemMonth()
    {
        $buyItems = Auth::user()->buyItems()->get('month');

        $buyItemMonth = [];

        foreach ($buyItems as $month) {
            $buyItemMonth[$month->month] = $month->month;
        }

        return $buyItemMonth;
    }

    /**
     * リクエストされた月からデータを絞り込むクエリスコープ
     *
     * @param [type] $query
     * @param [type] $month
     * @param [type] $tagName
     * @return void
     */
    public function scopeSearchMonth($query, $month, $tagName = null)
    {
        if (!empty($month) && !empty($tagName)) {
            return $query->where('month', $month)->where('item_tag_name', $tagName);
        } elseif (!empty($month)) {
            return $query->where('month', $month);
        }
    }
}
