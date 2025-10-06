<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function addLike(Product $product) //お気に入り登録
    {
        $user = Auth::user(); //ログインユーザーを取得

        // 既にお気に入り登録済みか確認
        $alreadyLiked = Like::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->exists();

        if (!$alreadyLiked) {
            // 登録されていなければ追加
            Like::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        // 現在のこの商品のお気に入り登録数
        $likeCount = $product->likes()->count();

        return response()->json([
            'success' => true,
            'liked' => !$alreadyLiked, // 今回登録されたかどうか
            'like_count' => $likeCount
        ]);
    }

    public function destroy(Product $product)
    {
        $user = Auth::user();

        Like::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json(['success' => true]);
    }
}