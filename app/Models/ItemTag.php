<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTag extends Model
{
    /**
     * item_tagsテーブルと関連
     *
     * @var string
     */
    protected $table = 'item_tags';

    /**
     * item_tagsテーブルの主キー
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
        'tag_name'
    ];

    /**
     * リレーション先の更新日時を更新する
     *
     * @var array
     */
    protected $touches = ['items'];

    /**
     * ユーザーモデルとのリレーション（多対1）
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * itemとのリレーション（多対多）
     */
    public function items()
    {
        return $this->belongsToMany(
            'App\Models\Item',
            'item_tag_maps',
            'item_tag_id',
            'item_id',
        );
    }
}
