<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //ダミーデータを代入する機能
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

    /*
    |--------------------------------------------------------------------------
    | Scopes（検索条件）
    |--------------------------------------------------------------------------
    */

    // 商品名検索
    public function scopeSearchByName($query, $search)
    {
        if (!empty($search)) {
            $query -> where('product_name', 'like', '%' . $search . '%');
        }    
    }

    // 価格の下限検索
    public function scopeMinPrice($query, $priceMin)
    {
        if ($priceMin !== null) {
            $query->where('price', '>=', $priceMin);
        }
    }

    // 価格の上限検索
    public function scopeMaxPrice($query, $priceMax)
    {
        if ($priceMax !== null) {
            $query->where('price', '<=', $priceMax);
        }
    }

     // ログインユーザーの商品を除外
    public function scopeExcludeOwn($query, $userId)
    {
        if ($userId !== null) {
            $query->where('user_id', '!=', $userId);
        }
    }
}
