<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ※ 元の dashboard ルートは無効化済み
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// 認証後のルート
Route::middleware(['auth', 'verified'])->group(function () {

    // ダッシュボードを商品一覧に置き換え
    Route::get('/dashboard', [ProductController::class, 'index'])
         ->name('dashboard');

    // 商品関連のルート
    Route::get('/products', [ProductController::class, 'index'])
         ->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])
         ->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])
         ->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])
         ->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])
         ->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])
         ->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])
         ->name('products.destroy');

    // プロフィール関連のルート
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');
});

// 認証関連
require __DIR__.'/auth.php';