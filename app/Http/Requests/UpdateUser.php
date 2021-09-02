<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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

        // ユーザー名の半角、全角の空白取り除き
        if (!empty($data['name'])) {
            $data['name'] = str_replace([' ', '　'], '', $data['name']);
        }

        return $data;
    }

    /**
     * ユーザー更新のバリデーション
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
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
            'name.required' => '名前は必須項目です',
            'name.string'   => '名前は文字でお願いします',
            'name.max'      => '名前は255文字以内でお願いします',
            'name.unique'   => '他のユーザーが既に使用しているユーザー名です',
        ];
    }
}
