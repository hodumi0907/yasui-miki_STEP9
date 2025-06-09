<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 商品取得
        $product = Product::find($validated['product_id']);
        
        // 在庫が足りない時のエラー
        if ($product -> stock < $validated['quantity']) {
            return response() -> json(['error' => '在庫不足です'], 400);
        }

        // 商品が存在しない時のエラー
        if (!$product) {
            return response() -> json(['error' => '商品が見つかりません'], 404);
        }

        // 在庫0の商品を購入しようとした時のエラー
        if ($product->stock == 0) {
            return response() -> json(['error' => 'この商品は在庫がありません'], 400);
        }

        // トランザクション開始
        DB::beginTransaction();

        try {
            // 購入処理（salesテーブルに記録）
            $sale = Sale::create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price_at_purchase' => $product->price, // 購入時の価格
            ]);

            // 在庫減算
            $product->stock -= $validated['quantity'];
            $product->save();

            // トランザクションをコミット
            DB::commit();

            return response()->json(['message' => '購入処理が完了しました'], 200);
        } catch (\Exception $e) {
            // エラーが発生した場合、ロールバック
            DB::rollBack();

            return response()->json(['error' => '購入処理に失敗しました', 'details' => $e->getMessage()], 500);
        }
    }
}
