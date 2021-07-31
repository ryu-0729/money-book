<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class ItemTagRepository implements RepositoryInterface
{
    /**
     * ログインユーザーのitemTagを取得
     *
     * @return $itemTags
     */
    public function getAll()
    {
        $itemTags = Auth::user()->itemTags()
            ->select('id', 'tag_name', 'updated_at')
            ->latest('updated_at')
            ->paginate(20);

        return $itemTags;
    }
}
