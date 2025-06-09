<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Company;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::all(); //既に存在するCompanyからランダムにcompany_idを割り当てる
        if ($companies->isEmpty()) { //$companiesが存在しない場合は何もしない
            return;
        }

        foreach ($companies as $company) { //$companies の中にある1件ずつの会社データを順番に取り出して繰り返す
            Product::factory()->create([ //Productモデルのファクトリーを使って1件の商品データを作成し、
                'company_id' => $company->id, //作成した商品の company_id に、現在の会社のIDを割り当てる
            ]);
        }
    }
}
