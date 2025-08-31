<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [ //データベースに追加が許可されている属性
        'user_id',
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this -> belongsTo(Product::class);
    }
}
