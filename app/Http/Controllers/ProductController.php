<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 検索条件を取得
        $searchKeyword = $request->input('keyword');
        $selectedCompany = $request->input('company_id');

        // クエリの作成
        $query = Product::query();
        
        if (!empty($searchKeyword)) {
            $query->where('name', 'like', "%{$searchKeyword}%");
        }

        if (!empty($selectedCompany)) {
            $query->where('company_id', $selectedCompany);
        }

        // 商品情報取得（ページネーション付き）
        $products = $query->paginate(10);

        // メーカー情報取得
        $companies = Company::all();

        return view('products.index', compact('products', 'companies', 'searchKeyword', 'selectedCompany'));
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }

    public function create()
    {
        // メーカー情報を取得
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'company_id' => 'required|exists:companies,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // 商品データを保存
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->company_id = $request->input('company_id');

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }

    public function show($id)
    {
        // 指定されたIDの商品情報を取得
        $product = Product::with('company')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        // 指定されたIDの商品情報を取得
        $product = Product::findOrFail($id);
        // メ
