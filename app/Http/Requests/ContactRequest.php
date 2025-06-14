<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //認可を許可
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //バリデーション
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            //バリデーションエラーメッセージ
            'name.required' => '名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '正しい形式で入力してください',
            'message.required' => 'お問い合わせ内容を入力してください',
        ];
    }
}
