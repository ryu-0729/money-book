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

    /**
     * リクエストされたタグのIDからタグ名の取得
     *
     * @param integer $tagId
     * @return $tagName
     */
    public function getTagNameByRequestTagId(int $tagId)
    {
        $tagName = Auth::user()->itemTags()
            ->select('tag_name')
            ->where('id', $tagId)
            ->firstOrFail();

        return $tagName;
    }

    /**
     * ユーザーが登録したタグ名の取得
     *
     * @return $tagNames
     */
    public function getTagNames()
    {
        $itemTags = $this->getAll();

        $tagNames = [0 => ''];

        foreach ($itemTags as $tag) {
            $tagNames[$tag->id] = $tag->tag_name;
        }

        return $tagNames;
    }
}
