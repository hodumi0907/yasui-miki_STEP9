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
        return redirect() -> route('index'); //ログイン状態なら商品一覧画面へリダイレクト
    } else {
        return redirect() -> route('login'); //未ログイン状態ならログイン画面へリダイレクト
    }
});

//自動で認証ルートを定義
Auth::routes();

//authミドルウェアで認証されたユーザーだけがアクセスできるルート
Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductsController::class); //商品関連へのリソースルート
    Route::get('/index', [App\Http\Controllers\ProductsController::class, 'index']) -> name('index');//商品一覧へのルート
    Route::get('/create', [App\Http\Controllers\ProductsController::class, 'create'])->name('create'); // 商品新規登録画面

});
