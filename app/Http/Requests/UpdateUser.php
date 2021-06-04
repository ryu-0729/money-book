<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は必須項目です',
            'name.string' => '名前は文字でお願いします',
            'name.max' => '名前は255文字以内でお願いします',
        ];
    }
}