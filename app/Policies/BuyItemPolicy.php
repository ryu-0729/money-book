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

    public function view(User $user, BuyItem $buyItem)
    {
        return $user->id === $buyItem->user_id;
    }

    /* public function create(User $user)
    {
        //
    } */

    public function update(User $user, BuyItem $buyItem)
    {
        return $user->id === $buyItem->user_id;
    }

    /* public function delete(User $user, BuyItem $buyItem)
    {
        //
    }

    public function restore(User $user, BuyItem $buyItem)
    {
        //
    }

    public function forceDelete(User $user, BuyItem $buyItem)
    {
        //
    } */
}
