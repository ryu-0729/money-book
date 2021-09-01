<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
