<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'purchase_quantity' => [
                'required',
                'integer',
                'min:1',
                // 在庫数は動的に取得するのでafterでバリデーションにカスタムメッセージを使う形が良いです
                // ここで在庫数制限をする場合はコントローラ側で追加チェック推奨
            ],
        ];
    }

    public function messages()
    {
        return [
            //バリデーションエラーメッセージ
            'purchase_quantity.required' => '購入数を入力してください。',
            'purchase_quantity.integer' => '購入数は整数で入力してください。',
            'purchase_quantity.min' => '購入数は1以上で入力してください。',
        ];
    }
}
