<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    /**
     * 商品一覧表示（検索対応）
     */
    public function index(Request $request)
    {
        $searchKeyword   = $request->input('keyword');       // 商品名キーワード
        $selectedCompany = $request->input('company_id');    // メーカーID

        $query = Product::with('company');

        // 商品名の部分一致
        if (!empty($searchKeyword)) {
            $query->where('name', 'like', "%{$searchKeyword}%");
        }

        // メーカーの絞り込み
        if (!empty($selectedCompany)) {
            $query->where('company_id', $selectedCompany);
        }

        $products = $query->paginate(10)->appends($request->except('page'));
        $companies = Company::all(); // 検索用メーカーリスト

        return view('products.index', compact(
            'products', 'companies', 'searchKeyword', 'selectedCompany'
        ));
    }

    /**
     * 商品登録フォーム表示
     */
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 商品登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'comment'    => 'nullable|string',
            'image'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('products.index')
                         ->with('success', '商品を登録しました。');
    }

    /**
     * 商品詳細表示
     */
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * 商品編集フォーム表示
     */
    public function edit($id)
    {
        $product   = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品更新処理
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'comment'    => 'nullable|string',
            'image'      => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products.index')
                         ->with('success', '商品を更新しました。');
    }

    /**
     * 商品削除処理
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index')
                         ->with('success', '商品を削除しました。');
    }
}