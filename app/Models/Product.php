<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //ダミーデータを代入する機能を使うことを宣言
    use HasFactory; 
    //データベースに追加が許可されている属性
    protected $fillable = [
        'product_name',
        'company_id',
        'user_id',
        'stock',
        'price',
        'description',
        'img_path',
    ];

    //Salesとのリレーション
    public function sales(){
        return $this -> hasMany(Sales::class);
    }

    //companyとのリレーション
    public function company()
    {
        return $this -> belongsTo(company::class);
    }

    //likeとのリレーション
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
}
