<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API 用のルート定義ファイルです。
| すべてのルートには自動的にプレフィックス `/api` が付きます。
|
| 例：
|   Route::get('/test', ...);
|   → 実際のアクセスURLは http://127.0.0.1:8000/api/test
|
*/

// ==========================
// 🔑 認証関連
// ==========================

// ログインAPI（トークンを発行）
Route::post('/login', [AuthController::class, 'login']);

// ログアウトAPI（Sanctum 認証必須 → トークン削除）
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// 認証済みユーザー情報の取得
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ==========================
// 🛒 商品関連（Sanctum 認証必須）
// ==========================
Route::middleware('auth:sanctum')->prefix('products')->group(function () {
    // 商品一覧取得（検索対応）
    Route::get('/', [ProductController::class, 'index']);
    // 商品登録
    Route::post('/', [ProductController::class, 'store']);
    // 商品詳細取得
    Route::get('/{id}', [ProductController::class, 'show']);
    // 商品更新
    Route::put('/{id}', [ProductController::class, 'update']);
    // 商品削除
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

// ==========================
// 💳 購入関連
// ==========================
// 購入処理API（外部公開・認証なし）
Route::post('/purchase', [PurchaseController::class, 'store']);