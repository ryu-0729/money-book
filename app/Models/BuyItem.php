<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
     * リクエストされた月からデータを絞り込むクエリスコープ
     *
     * @param $query
     * @param $month
     * @param $tagName
     * @return void
     */
    public function scopeSearchMonthAndTagName($query, $month, $tagName = '')
    {
        if (!empty($month) && !empty($tagName)) {
            return $query->where('month', $month)->where('item_tag_name', $tagName);
        } elseif (!empty($month)) {
            return $query->where('month', $month);
        } elseif (!empty($tagName)) {
            return $query->where('item_tag_name', $tagName);
        }
    }
}
