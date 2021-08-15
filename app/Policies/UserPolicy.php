<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /* public function viewAny(User $user)
    {
        //
    } */

    /**
     * 自身の詳細のみ閲覧可能
     *
     * @param User $user
     * @param User $model
     * @return void
     */
    public function view(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * 自身の編集、更新のみ可能
     *
     * @param User $user
     * @param User $model
     * @return void
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /* public function delete(User $user, User $model)
    {
        //
    }

    public function restore(User $user, User $model)
    {
        //
    }

    public function forceDelete(User $user, User $model)
    {
        //
    } */
}
