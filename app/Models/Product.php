<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;//使うツールを取り込む
use Illuminate\Database\Eloquent\Model;

class Product extends Model//Productという名前のツールを作る
{
    use HasFactory; //ダミーデータを代入する機能を使うことを宣言

    protected $fillable = [ //データベースに追加が許可されている属性
        'company_id',
        'product_name',
        'stock',
        'price',
        'comment',
        'img_path',
    ];

    public function sales() //Salesとのリレーション。Salesに対してProductは親（hasMany）にあたる
    {
        return $this -> hasMany(Sales::class);
    }

    public function company() //companiesとのリレーション。companiesに対してProductは子（belongsTo）にあたる
    {
        return $this -> belongsTo(company::class);
    }
}
