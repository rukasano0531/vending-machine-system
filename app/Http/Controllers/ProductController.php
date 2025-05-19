<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    /**
     * 一覧表示
     */
    public function index(Request $request)
    {
        // 検索条件
        $searchKeyword   = $request->input('keyword');
        $selectedCompany = $request->input('company_id');

        // クエリ組み立て
        $query = Product::with('company');
        if (!empty($searchKeyword)) {
            $query->where('name', 'like', "%{$searchKeyword}%");
        }
        if (!empty($selectedCompany)) {
            $query->where('company_id', $selectedCompany);
        }

        // ページネーション
        $products = $query->paginate(10)->appends($request->except('page'));

        // メーカー一覧
        $companies = Company::all();

        return view('products.index', compact(
            'products', 'companies', 'searchKeyword', 'selectedCompany'
        ));
    }

    /**
     * 新規登録フォーム表示
     */
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 新規登録処理
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'comment'    => 'nullable|string',
            'image'      => 'nullable|image|max:2048',
        ]);

        // 画像アップロード
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // 登録
        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', '商品を登録しました。');
    }

    /**
     * 詳細表示
     */
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * 編集フォーム表示
     */
    public function edit($id)
    {
        $product   = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 更新処理
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

        return redirect()
            ->route('products.index')
            ->with('success', '商品を更新しました。');
    }

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()
            ->route('products.index')
            ->with('success', '商品を削除しました。');
    }
}