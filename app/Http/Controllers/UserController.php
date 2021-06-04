<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUser; // UpdateUserバリデーションを利用

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function show(User $user)
    {
        $this->authorize($user);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize($user);
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUser $request, User $user)
    {
        $this->authorize($user);
        $user->update($request->validated());

        return redirect()->route('users.show', [$user])
            ->with('message', 'マイページを更新しました');
    }

    public function destroy(User $user)
    {
        //
    }
}
