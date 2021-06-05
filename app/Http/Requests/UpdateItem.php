<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItem extends FormRequest
{
    public function authorize()
    {
        return true;
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
