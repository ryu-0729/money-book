<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // ログインユーザーを取得したいため追記
use Kyslik\ColumnSortable\Sortable; // ソート機能

class Item extends Model
{
    use Sortable;

    /**
     * itemsテーブルと関連
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * itemsテーブルの主キー
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
        'name', 'price'
    ];

    /**
     * ソート許可カラム
     *
     * @var array
     */
    public $sortable = [
        'name', 'price',
    ];

    /**
     * Userモデルとのリレーション（多対1）
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * ItemTagとのリレーション（多対多）
     *
     * @return void
     */
    public function itemTags()
    {
        return $this->belongsToMany(
            'App\Models\ItemTag',
            'item_tag_maps',
            'item_id',
            'item_tag_id',
        );
    }

    /**
     * ユーザーが登録した商品の名前を配列で取得
     *
     * @return void
     */
    public function getAuthUserItems()
    {
        $items = Auth::user()->items()->get('name');

        $itemsName = [];

        foreach ($items as $name) {
            $itemsName[$name->name] = $name->name;
        }

        return $itemsName;
    }

    /**
     * リクエストされた個数から金額を計算する処理
     *
     * @param [type] $name
     * @param [type] $quantity
     * @return void
     */
    public function getPrice($name, $quantity)
    {
        $getPrice = Auth::user()->items()->where('name', $name)
            ->firstOrFail();

        $price = $getPrice->price * $quantity;

        return $price;
    }
}
