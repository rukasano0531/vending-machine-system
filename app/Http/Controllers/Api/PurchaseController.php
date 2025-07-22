<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    /**
     * 購入処理API
     * 
     * リクエストパラメータ:
     * - product_id: 購入する商品のID
     * - quantity: 購入数
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $productId = $validated['product_id'];
        $quantity  = $validated['quantity'];

        try {
            DB::beginTransaction();

            $product = Product::lockForUpdate()->find($productId);

            // 在庫確認
            if ($product->stock < $quantity) {
                return response()->json([
                    'message' => '在庫が不足しているため、購入できません。',
                ], 400);
            }

            // salesテーブルにレコードを追加
            Sale::create([
                'product_id' => $productId,
                'quantity'   => $quantity,
                'price'      => $product->price * $quantity,
            ]);

            // 在庫数を減算
            $product->stock -= $quantity;
            $product->save();

            DB::commit();

            return response()->json([
                'message' => '購入が完了しました。',
                'remaining_stock' => $product->stock,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => '購入処理中にエラーが発生しました。',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}