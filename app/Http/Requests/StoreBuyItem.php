<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuyItem extends FormRequest
{
    /**
     * 認可
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 購入商品登録のバリデーション
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'month' => ['required', 'numeric', 'between:1,12'],
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
            'name.required' => '商品名を選択してください',
            'name.string' => '商品名は文字でお願いします',
            'quantity.required' => '個数は必須です',
            'quantity.numeric' => '個数は数字でお願いします',
            'quantity.min' => '個数が不正な値です',
            'month.required' => '購入月は必須です',
            'month.numeric' => '購入月は数字でお願いします',
            'month.between' => '1~12から選んでください',
        ];
    }
}
