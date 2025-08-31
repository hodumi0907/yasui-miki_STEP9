<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest; // バリデーション
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRequest $request)
    {
        $query = Product::query();

        // 「検索キーワード」が空文字ではない場合はそのキーワードを含む商品名だけに絞る
        if ($request -> has('search') && $request -> search != '') {
            $query -> where('product_name', 'like', '%' . $request->search . '%');
        }

        // 価格の下限が指定されていたら、その価格以上の商品だけに絞る
        if ($request->price_min !== null) {
            $query->where('price', '>=', $request->price_min);
        }

        // 価格の上限が指定されていたら、その価格以下の商品だけに絞る
        if ($request->price_max !== null) {
            $query->where('price', '<=', $request->price_max);
        }

        // ログインユーザー以外の商品だけ表示
        $query->where('user_id', '!=', Auth::id());

        // company_id（会社番号）で昇順に並べて、条件に合う商品を全部取得
        $products = $query->orderBy('company_id', 'asc')->get();

        // 取得した商品の一覧を「index」ビューに渡して表示
        return view('userpage.index', compact('products'));
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
    public function show(Request $request, $id)
    {
        //resources/views/products/detail.blade.phpを表示する
        //商品詳細でsearch と company_idを受け取る
        $product = Product::with('company') -> findOrFail($id);
        return view('userpage.detail', compact('product')) -> with([
            'search' => $request -> query('search'),
            'company_id' => $request -> query('company_id')
        ]);
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
