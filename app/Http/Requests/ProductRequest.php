<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'product_name' => 'required', //required＝必須
            'company_id' => 'required',
            'price' => 'required|integer|min:0', //必須、整数のみ（-1、0.1不可）、0でも可
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable', //nullable＝未入力可
            'img_path' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください',
            'price.required' => '価格を入力してください',
            'price.integer' => '価格は整数で入力してください',
            'price.min' => '価格は0以上で入力してください',
            'stock.required' => '在庫数を入力してください',
            'stock.integer' => '在庫数は整数で入力してください',
            'stock.min' => '在庫数は0以上で入力してください',
            'img_path.image' => 'アップロードできるのは画像ファイルのみです',
        ];
    }
}
