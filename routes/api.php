<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PurchaseController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 認証済みユーザー情報取得
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/purchase/{product}', [PurchaseController::class, 'purchase']); //購入処理
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Auth::attempt() が成功した時点でユーザーは認証されている
    $user = Auth::user();

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token], 200);
});

// テスト用ルート（Postmanやブラウザで接続確認）
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});