<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //お気に入り登録処理
    public function addLike(Product $product)
    {
        //ログインユーザーを取得
        $user = Auth::user();
        // 既にお気に入り登録済みか確認
        if (!$product->likedBy($user)) {
            // お気に入り登録していればlikesテーブルからレコード削除
            Like::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        return response()->json([
            'likes_count' => $ProduckLike->likes()->count(),
        ]);
    }

    //お気に入り削除処理
    public function destroy(Product $product)
    {
        //ログインユーザーを取得
        $user = Auth::user();
        // 既にお気に入り登録済みか確認
        if ($product->likedBy($user)){
        // 登録されていなければ追加
            Like::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->delete();
        }

        return response()->json([
            'likes_count' =>$ProduckLike->likes()->count(),
            ]);
    }
}