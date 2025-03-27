<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController; // ProductController を追加

Route::get('/', function () {
    return view('welcome');
});
// 認証機能を有効化
Auth::routes();

// 認証が必要なページ
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 商品関連のルート
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 商品新規登録のルート
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // 商品詳細画面のルート
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // ✅ 編集機能のルートを追加
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // 編集画面
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update'); // 更新処理
});

// ユーザー新規登録画面
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
