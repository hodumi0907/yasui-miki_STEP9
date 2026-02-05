<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccountRequest;
use App\Models\Sale;
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
        $purchasedProducts = Sale::with('product')
            ->where('user_id', $user->id)
            ->get();

        return view('mypage.user_index', compact('user', 'myProducts', 'purchasedProducts'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypage.user_edit', compact('user'));
    }

    public function update(AccountRequest $request)
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

        return redirect()
            ->route('mypage.user_index')
            ->with('success', 'アカウント情報を更新しました。');
    }
}
