<?php

namespace App\Policies;

use App\Models\BuyItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyItemPolicy
{
    use HandlesAuthorization;

    /* public function viewAny(User $user)
    {
        //
    } */

    /**
     * ユーザー自身が購入登録した商品の詳細のみ閲覧可能
     *
     * @param User $user
     * @param BuyItem $buyItem
     * @return void
     */
    public function view(User $user, BuyItem $buyItem)
    {
        return $user->id === $buyItem->user_id;
    }

    /* public function create(User $user)
    {
        //
    } */

    /**
     * ユーザー自身が購入登録した商品のみ編集、更新が可能
     *
     * @param User $user
     * @param BuyItem $buyItem
     * @return void
     */
    public function update(User $user, BuyItem $buyItem)
    {
        return $user->id === $buyItem->user_id;
    }

    /**
     * ユーザー自身が購入登録した商品のみ削除可能
     *
     * @param User $user
     * @param BuyItem $buyItem
     * @return void
     */
    public function delete(User $user, BuyItem $buyItem)
    {
        return $user->id === $buyItem->user_id;
    }

    /* public function restore(User $user, BuyItem $buyItem)
    {
        //
    }

    public function forceDelete(User $user, BuyItem $buyItem)
    {
        //
    } */
}
