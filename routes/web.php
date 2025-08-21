<?php

use Illuminate\Support\Facades\Route; //"Route"というツールを使うために必要な部品を取り込む
use Illuminate\Support\Facades\Auth; //"Auth"という部品（ユーザー認証（ログイン）に関する処理）を使う
use App\Http\Controllers\ProductsController; //商品一覧、商品詳細、購入画面（購入者向け）
use App\Http\Controllers\PurchaseController; //購入処理（購入確定・在庫更新など）
use App\Http\Controllers\ContactController; //お問い合わせフォーム
use App\Http\Controllers\ProductsManageController; //商品出品登録・編集・出品詳細
use App\Http\Controllers\MyPageController; //ユーザー情報（マイページ・アカウント編集）

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

//ホーム画面のリダイレクト先（ログイン済⇒商品一覧、未ログイン⇒ログイン画面）
Route::get('/', function () {
    if (Auth::check()) {
        return redirect() -> route('products.index');
    } else {
        return redirect() -> route('login');
    }
});

//自動の認証ルート定義
Auth::routes();

//認証が必要なアクセスルート
Route::group(['middleware' => 'auth'], function () {
    // ▼ 商品閲覧・購入関連（購入者向け）
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');//商品一覧
    Route::get('/products/{product}', [ProductsController::class, 'show'])->name('products.detail'); //商品詳細
    Route::get('/products/{product}/buy', [PurchaseController::class, 'showPurchaseForm'])->name('purchase.form'); //購入
    Route::post('/products/{product}/buy', [PurchaseController::class, 'purchase'])->name('purchase.process'); //購入処理

    // ▼ 出品商品管理（出品者向け/ProductsManageController)
    Route::get('/mypage/products/create', [ProductsManageController::class, 'create'])->name('products.create'); //商品新規登録
    Route::post('/products', [ProductsManageController::class, 'store'])->name('products.store'); //商品新規登録処理
    Route::get('/mypage/products/{product}', [ProductsManageController::class, 'show'])->name('products.show'); //商品詳細
    Route::get('/mypage/products/{product}/edit', [ProductsManageController::class, 'edit'])->name('products.edit'); //商品編集
    Route::put('/mypage/products/{product}', [ProductsManageController::class, 'update'])->name('products.update'); //商品編集登録処理
    Route::delete('/mypage/products/{product}', [ProductsManageController::class, 'destroy'])->name('products.destroy'); //商品削除処理

    // ▼ マイページ関連(MyPageController)
    Route::get('/mypage/user_index', [MyPageController::class, 'user_index'])->middleware('auth')->name('mypage.user_index'); //マイページ
    Route::get('/mypage/edit', [MyPageController::class, 'edit'])->name('mypage.edit'); //ユーザー情報編集
    Route::put('/mypage/update', [MyPageController::class, 'update'])->name('mypage.update'); //ユーザー情報更新処理

    // ▼ お問い合わせ(ContactController)
    Route::get('/contact', [ContactController::class, 'create'])->name('contact'); //フォーム表示
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store'); //送信処理
});
