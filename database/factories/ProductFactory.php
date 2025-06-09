<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class; //このファクトリーが生成するデータの対象モデルがProductクラスであると指定

    public function definition():array
    {
        return [
            'company_id' => Company::factory(), //このProductデータに関連するCompanyデータを生成するためにCompanyファクトリーを呼び出す
            'product_name' => $this -> faker -> word, //ランダムな単語を商品名として生成
            'price' => $this -> faker -> numberBetween(100, 10000),  //100から10,000の範囲でランダムな整数を生成し、価格として設定
            'stock' => $this -> faker -> randomDigit, //0から9の範囲でランダムな数字を在庫数として生成
            'description' => $this -> faker -> sentence, //ランダムな文をコメント（商品の説明文）として生成
            'img_path' => 'https://picsum.photos/200/300', //ランダム画像生成サービス（https://picsum.photos）のURLを画像パスとして指定
            //faker->　は、Fakerライブラリを使用するときにつかう
        ];
    }
}
