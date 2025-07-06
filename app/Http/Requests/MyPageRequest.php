<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MyPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // ログインユーザーのみ許可
        return Auth::check(); // 初期:false
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'name_kanji' => 'required|string|max:255',
            'name_kana' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名は必須です。',
            'name_kanji.required' => '名前（漢字）は必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'email.unique' => 'そのメールアドレスは既に使用されています。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード（確認用）が一致しません。',
        ];
    }
}
