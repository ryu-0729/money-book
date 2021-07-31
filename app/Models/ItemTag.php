<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTag extends Model
{
    protected $fillable = [
        'tag_name'
    ];

    // Userモデルとのリレーション
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
