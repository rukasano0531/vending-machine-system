<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    // 商品一覧を表示
    public function index()
    {
        $products = Product::with('company')->get();
        return view('products.index', compact('products'));
    }

    // ✅ 商品新規登録画面を表示
    public function create()
    {
        $companies = Company::all(); // メーカー一覧を取得
        return view('products.create', compact('companies'));
    }

    // ✅ 商品をデータベースに登録
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name'       => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'comment'    => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像のアップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        // 商品を登録
        Product::create([
            'name'       => $request->name,
            'company_id' => $request->company_id,
            'price'      => $request->price,
            'stock'      => $request->stock,
            'comment'    => $request->comment,
            'image'      => $imagePath,
        ]);

        // ✅ 商品一覧画面にリダイレクト
        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }
}
