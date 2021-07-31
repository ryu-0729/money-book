<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Itemモデルとのリレーション
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    // BuyItemモデルとのリレーション
    public function buyItems()
    {
        return $this->hasMany('App\Models\BuyItem');
    }

    // UserGoalモデルとのリレーション
    public function userGoal()
    {
        return $this->hasOne('App\Models\UserGoal');
    }

    // ItemTagモデルとのリレーション
    public function itemTags()
    {
        return $this->hasMany('App\Models\ItemTag');
    }
}
