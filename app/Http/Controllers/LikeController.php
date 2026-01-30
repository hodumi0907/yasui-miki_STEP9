<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //お気に入り登録処理
    public function toggle(Product $product)
    {
        //dd($product); 処理が強制終了するため削除

        //ログインユーザーを取得
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($like) {
            //お気に入り済み→解除
            $like->delete();
            $liked = false;
        } else {
            //未お気に入り→登録
            Like::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $liked = true;
        }

        //お気に入り登録したことを返す
        return response()->json([
            'liked' => $liked,
        ]);
    }
}