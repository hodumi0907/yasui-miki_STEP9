<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // 商品モデルを使う前提
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // 購入画面表示
    public function showPurchaseForm(Product $product)
    {
        return view('buyer', compact('product'));
    }

    // 購入処理（購入確定）
    public function purchase(PurchaseRequest $request, Product $product)
    {
        $purchaseQuantity = (int) $request->input('purchase_quantity');

        // 在庫数チェック
        if ($purchaseQuantity > $product->stock) {
            return redirect()->back()->withErrors(['purchase_quantity' => '在庫がありません。'])->withInput();
        }

        DB::beginTransaction();

        try {
            // 在庫が足りるかチェック
            $product->stock -= $purchaseQuantity;
            $product->save();

            // salesテーブルへの購入履歴登録
            Sale::create([
                'user_id'     => auth()->id(), // ログインユーザーのID
                'product_id'  => $product->id,
                'quantity'     => $purchaseQuantity,
            ]);

            DB::commit();

            // 購入後は商品一覧にリダイレクト
            return redirect()->route('products.index')->with('success', '購入が完了しました。');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '購入処理に失敗しました。');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
