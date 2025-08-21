<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class MyPageController extends Controller
{
    //
    public function user_index()
    {
        $user = Auth::user();

        // 出品商品
        $myProducts = Product::where('user_id', $user->id)->get();

        // 購入した商品
        // 購入した商品（モデルが未作成なので今は空のコレクション）
        $purchasedProducts = collect(); // 空のコレクション
        // 例えばPurchaseモデルがあって、user_id（購入者ID）で絞る場合
        //$purchasedProducts = Purchase::where('user_id', $user->id)->with('product')->get();

        return view('mypage.user_index', compact('user', 'myProducts', 'purchasedProducts'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypage.user_edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // データ更新
        $user->name = $request->name;
        $user->name_kanji = $request->name_kanji;
        $user->name_kana = $request->name_kana;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('mypage.user_index')->with('success', 'アカウント情報を更新しました。');
    }
}
