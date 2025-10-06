<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    //Userとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Productとのリレーション
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
