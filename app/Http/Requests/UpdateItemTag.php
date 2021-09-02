<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemTag extends FormRequest
{
    /**
     * 認可
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 入力値のデータ更新
     *
     * @return void
     */
    public function validationData()
    {
        $data = $this->all();

        // タグ名の半角、全角の空白取り除き
        if (!empty($data['tag_name'])) {
            $data['tag_name'] = str_replace([' ', '　'], '', $data['tag_name']);
        }

        return $data;
    }

    /**
     * 商品タグ更新のバリデーション
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag_name' => ['required', 'string', 'max:30'],
        ];
    }

    /**
     * バリデーションメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'tag_name.required' => 'タグ名は必須です',
            'tag_name.string'   => 'タグ名は文字でお願いします',
            'tag_name.max'      => 'タグ名は30文字以内でお願いします',
        ];
    }
}
