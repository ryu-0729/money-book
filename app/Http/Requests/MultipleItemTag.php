<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MultipleItemTag extends FormRequest
{
    /**
     * 認可
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 複数商品に対してのタグ更新バリデーション
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag_id' => ['required'],
            'item'   => ['required'],
        ];
    }

    /**
     * バリデーションメッセージ
     *
     * @return void
     */
    public function messages()
    {
        return [
            'tag_id.required' => 'タグの選択をしてください',
            'item.required'   => '商品を選択してください',
        ];
    }
}
