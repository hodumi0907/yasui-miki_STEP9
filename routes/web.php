<?php

use Illuminate\Support\Facades\Route; //"Route"というツールを使うために必要な部品を取り込む
use Illuminate\Support\Facades\Auth; //"Auth"という部品（ユーザー認証（ログイン）に関する処理）を使う
use App\Http\Controllers\ProductsController; //商品一覧、商品詳細、購入画面（購入者向け）
use App\Http\Controllers\PurchaseController; //購入処理（購入確定・在庫更新など）
use App\Http\Controllers\ContactController; //お問い合わせフォーム
use App\Http\Controllers\ProductManageController; //商品出品登録・編集・出品詳細
use App\Http\Controllers\MyPageController; //マイページ（購入履歴・出品履歴）
use App\Http\Controllers\AccountController; //アカウント情報編集

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
    Route::get('/products/{product}/buy', [PurchaseController::class, 'showPurchaseForm'])->name('purchase.form'); //購入
    Route::post('/products/{product}/buy', [PurchaseController::class, 'purchase'])->name('purchase.process'); //購入処理

    // ▼ 出品商品管理（出品者向け/ProductManageController)
    Route::get('/mypage/products/create', [ProductManageController::class, 'create'])->name('products.create'); //商品新規登録画面
    Route::post('/products', [ProductManageController::class, 'store'])->name('products.store'); //商品登録処理
    Route::get('/products/{product}', [ProductManageController::class, 'show'])->name('products.show'); //商品詳細ページ
    Route::get('/mypage/products/{product}/edit', [ProductManageController::class, 'edit'])->name('products.edit'); //商品編集画面
    Route::put('/mypage/products/{product}', [ProductManageController::class, 'update'])->name('products.update'); //商品登録処理
    Route::delete('/mypage/products/{product}', [ProductManageController::class, 'destroy'])->name('products.destroy'); //商品削除処理

    // ▼ マイページ関連(MyPageController)
    Route::get('/mypage/user_index', [MyPageController::class, 'user_index'])->middleware('auth')->name('mypage.user_index'); //マイページ

    // ▼ アカウント管理(AccountController)
    Route::get('/user/edit', [AccountController::class, 'edit'])->name('user.edit'); //ユーザー情報編集
    Route::put('/user/update', [AccountController::class, 'update'])->name('user.update'); //ユーザー情報更新処理（PUT）

    // ▼ お問い合わせ(ContactController)
    Route::get('/contact', [ContactController::class, 'create'])->name('contact'); //フォーム表示
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store'); //送信処理
});
