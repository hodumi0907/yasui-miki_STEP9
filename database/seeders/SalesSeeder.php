<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sales;
use App\Models\Product;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //既に存在するProductからランダムにproduct_idを割り当てる
        $products = Product::all();
        //Productが存在しない場合は何もしない
        if ($products->isEmpty()) {
            return;
        }
        //salesモデルのファクトリーを呼び出してダミーを10件作成
        Sales::factory()
            ->count(10)
            ->create([
                'product_id' => $products->random()->id,
            ]);

        foreach ($products as $product) { //$productsの中にある1件ずつのデータを順番に取り出して繰り返す
            Sales::factory()->create([ //Salesモデルのファクトリーを使って1件の商品データを作成し、
                'product_id' => $product->id, //作成した商品の product_idに、現在の会社のIDを割り当てる
            ]);
        }
    }
}
