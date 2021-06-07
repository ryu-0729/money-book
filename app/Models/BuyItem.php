<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
