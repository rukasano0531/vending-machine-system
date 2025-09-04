<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * 商品一覧を返すAPI
     */
    public function index()
    {
        // 商品を全件取得（必要なら with('company') でリレーションも取得可能）
        $products = Product::with('company')->get();

        // JSON で返す
        return response()->json([
            'status' => 'success',
            'data'   => $products
        ]);
    }
}