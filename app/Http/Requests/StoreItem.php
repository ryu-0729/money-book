<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItem extends FormRequest
{
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

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'商品名は必須です',
            'name.string' => '商品名は文字でお願いします',
            'price.required' => '金額は必須です',
            'price.numeric' => '金額は数値でお願いします',
            'price.min' => '金額が不正の値です',
        ];
    }
}
