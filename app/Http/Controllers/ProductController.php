<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    /**
     * 商品一覧表示（検索対応）
     */
    public function index(Request $request)
    {
        $searchKeyword   = $request->input('keyword');
        $selectedCompany = $request->input('company_id');
        $priceMin        = $request->input('price_min');
        $priceMax        = $request->input('price_max');
        $stockMin        = $request->input('stock_min');
        $stockMax        = $request->input('stock_max');

        $products = Product::search(
            $searchKeyword,
            $selectedCompany,
            $priceMin,
            $priceMax,
            $stockMin,
            $stockMax
        )->paginate(10)->appends($request->except('page'));

        if ($products->isEmpty()) {
            \Session::flash('error', config('message.not_found'));
        }

        $companies = Company::all();

        return view('products.index', compact(
            'products',
            'companies',
            'searchKeyword',
            'selectedCompany',
            'priceMin',
            'priceMax',
            'stockMin',
            'stockMax'
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

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $validated['image'] = $path;
            }

            Product::create($validated);

            DB::commit();
            return redirect()->route('products.index')
                             ->with('success', config('message.create_success'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')
                             ->with('error', config('message.create_error') ?? '商品登録に失敗しました。');
        }
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

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $validated['image'] = $path;
            }

            $product->update($validated);

            DB::commit();
            return redirect()->route('products.index')
                             ->with('success', config('message.update_success'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')
                             ->with('error', config('message.update_error') ?? '商品更新に失敗しました。');
        }
    }

    /**
     * 商品削除処理
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $product->delete();

            DB::commit();
            return redirect()->route('products.index')
                             ->with('success', config('message.delete_success'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')
                             ->with('error', config('message.delete_error'));
        }
    }
}