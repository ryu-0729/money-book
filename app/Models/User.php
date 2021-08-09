<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * usersテーブルと関連
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * usersテーブルの主キー
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
        'name', 'email', 'password',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * ネイティブなタイプへキャストする属性
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Itemモデルとのリレーション（1対多）
     *
     * @return void
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    /**
     * BuyItemモデルとのリレーション（1対多）
     *
     * @return void
     */
    public function buyItems()
    {
        return $this->hasMany('App\Models\BuyItem');
    }

    /**
     * UserGoalモデルとのリレーション（1対1）
     *
     * @return void
     */
    public function userGoal()
    {
        return $this->hasOne('App\Models\UserGoal');
    }

    /**
     * ItemTagモデルとのリレーション（1対多）
     *
     * @return void
     */
    public function itemTags()
    {
        return $this->hasMany('App\Models\ItemTag');
    }
}
