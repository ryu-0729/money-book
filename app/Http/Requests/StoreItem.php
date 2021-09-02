<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItem extends FormRequest
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

        // 商品名の半角、全角の空白取り除き
        if (!empty($data['name'])) {
            $data['name'] = str_replace([' ', '　'], '', $data['name']);
        }

        return $data;
    }

    /**
     * 商品登録のバリデーション
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name'  => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }

    /**
     * 商品登録のバリデーションメッセージ
     *
     * @return void
     */
    public function messages()
    {
        return [
            'name.required'  =>'商品名は必須です',
            'name.string'    => '商品名は文字でお願いします',
            'price.required' => '金額は必須です',
            'price.numeric'  => '金額は数値でお願いします',
            'price.min'      => '金額が不正の値です',
        ];
    }
}
