<?php

namespace App\Policies;

use App\Models\ItemTag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any item tags.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    /* public function viewAny(User $user)
    {
        //
    } */

    /**
     * Determine whether the user can view the item tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ItemTag  $itemTag
     * @return mixed
     */
    /* public function view(User $user, ItemTag $itemTag)
    {
        //
    } */

    /**
     * Determine whether the user can create item tags.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    /* public function create(User $user)
    {
        //
    } */

    /**
     * タグ編集の権限設定
     * ユーザー自身のタグ以外の変更はできない
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ItemTag  $itemTag
     * @return mixed
     */
    public function update(User $user, ItemTag $itemTag)
    {
        return $user->id === $itemTag->user_id;
    }

    /**
     * タグ削除処理の権限設定
     * ユーザー自身のタグ以外は削除不可
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ItemTag  $itemTag
     * @return mixed
     */
    public function delete(User $user, ItemTag $itemTag)
    {
        return $user->id === $itemTag->user_id;
    }

    /**
     * Determine whether the user can restore the item tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ItemTag  $itemTag
     * @return mixed
     */
    /* public function restore(User $user, ItemTag $itemTag)
    {
        //
    } */

    /**
     * Determine whether the user can permanently delete the item tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ItemTag  $itemTag
     * @return mixed
     */
    /* public function forceDelete(User $user, ItemTag $itemTag)
    {
        //
    } */
}
