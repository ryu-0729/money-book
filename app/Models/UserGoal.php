<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGoal extends Model
{
    protected $fillable = [
        'title', 'price'
    ];

    // Userモデルとのリレーション
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
