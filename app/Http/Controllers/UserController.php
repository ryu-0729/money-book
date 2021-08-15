<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateUser; // UpdateUserバリデーションを利用

class UserController extends Controller
{
    /* public function index()
    {
        //
    } */

    /**
     * ユーザー詳細ページ
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        $this->authorize($user);
        return view('users.show', compact('user'));
    }

    /**
     * ユーザー編集ページ
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        $this->authorize($user);
        return view('users.edit', compact('user'));
    }

    /**
     * ユーザー更新
     *
     * @param UpdateUser $request
     * @param User $user
     * @return void
     */
    public function update(UpdateUser $request, User $user)
    {
        $this->authorize($user);
        $user->update($request->validated());

        return redirect()->route('users.show', [$user])
            ->with('message', 'マイページを更新しました');
    }

    /* public function destroy(User $user)
    {
        //
    } */
}
