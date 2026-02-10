<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest; // バリデーション
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Like;
use Illuminate\Http\JsonResponse; // 追加（返却型明示用）

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRequest $request)
    {
        $products = Product::query()
        ->searchByName($request->search)
        ->minPrice($request->price_min)
        ->maxPrice($request->price_max)
        ->excludeOwn(Auth::id())
        ->orderBy('id', 'asc')
        ->get();

        // 取得した商品の一覧を表示
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
        $liked = Like::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        return view('userpage.detail', compact('product', 'liked')) -> with([
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
