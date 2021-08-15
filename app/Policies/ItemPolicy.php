<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /* public function viewAny(User $user)
    {
        //
    } */

    /**
     * ユーザー自身が登録した商品の詳細のみ
     *
     * @param User $user
     * @param Item $item
     * @return void
     */
    public function view(User $user, Item $item)
    {
        return $user->id === $item->user_id;
    }

    /* public function create(User $user)
    {
        //
    } */

    /**
     * ユーザー自身が登録した商品の編集、更新のみ
     *
     * @param User $user
     * @param Item $item
     * @return void
     */
    public function update(User $user, Item $item)
    {
        return $user->id === $item->user_id;
    }

    /**
     * ユーザー自身が登録した商品の削除のみ
     *
     * @param User $user
     * @param Item $item
     * @return void
     */
    public function delete(User $user, Item $item)
    {
        return $user->id === $item->user_id;
    }

    /* public function restore(User $user, Item $item)
    {
        //
    }

    public function forceDelete(User $user, Item $item)
    {
        //
    } */
}
