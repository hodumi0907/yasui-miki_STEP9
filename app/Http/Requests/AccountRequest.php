<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 初期:false
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $userId = $this->user()->id;
        return [
            'name' => 'required|string|max:255',
            'name_kanji' => 'required|string|max:255|regex:/^[^\x01-\x7E\xA1-\xDF]+$/u',
            'name_kana' => 'required|string|max:255|regex:/^[\p{Katakana}ー ]+$/u',
            'email' => 'required|email|unique:users,email,'.$userId,
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
        'name.required' => '全角で入力してください',
        'name_kanji.required' => '全角で入力してください',
        'name_kanji.regex' => '全角で入力してください',
        'name_kana.required' => '全角で入力してください',
        'name_kana.regex' => '全角で入力してください',
        'email.required' => 'メールアドレスを入力してください',
        'email.email' => '正しい形式で入力してください',
        'email.unique' => 'このメールアドレスは既に登録されています',
        'email.regex' => 'メールアドレスは半角英数字で入力してください',
        'password.min' => 'パスワードは8文字以上で入力してください',
        'password.confirmed' => 'パスワード（確認用）が一致しません',
        ];
    }
}
