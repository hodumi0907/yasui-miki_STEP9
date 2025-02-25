<?php

use Illuminate\Support\Facades\Route; //"Route"というツールを使うために必要な部品を取り込む
use App\Http\Controllers\ProductsController; //ProductControllerに繋ぐ
use Illuminate\Support\Facades\Auth; //"Auth"という部品（ユーザー認証（ログイン）に関する処理）を使う

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//WEBサイトのホームページにアクセスしたときの処理
Route::get('/', function () {
    //ログイン状態なら商品一覧ページ（index.blade.php / ProductControllerのindexメソッド）にリダイレクト
    if (Auth::check()) {
        return redirect() -> route('products.index'); //ログイン状態なら商品一覧画面へリダイレクト
    } else {
        return redirect() -> route('login'); //未ログイン状態ならログイン画面へリダイレクト
    }
});

//自動で認証ルートを定義
Auth::routes();

//authミドルウェアで認証されたユーザーだけがアクセスできるルート
Route::group(['middleware' => 'auth'], function () {
    Route::get('/products', [ProductsController::class, 'index']) -> name('products.index');//商品一覧
    Route::get('/products/create', [ProductsController::class, 'create']) -> name('products.create'); //商品新規登録画面
    Route::get('/products/{product}', [ProductsController::class, 'show']) -> name('products.show'); //商品詳細ページ
    Route::get('/products/{product}/edit', [ProductsController::class, 'edit']) -> name('products.edit'); //商品編集画面
    Route::post('/products', [ProductsController::class, 'store']) -> name('products.store'); //商品登録処理
    Route::put('/products/{product}', [ProductsController::class, 'update']) -> name('products.update'); //商品登録処理
    Route::delete('/products/{product}', [ProductsController::class, 'destroy']) -> name('products.destroy'); //商品削除処理
});
