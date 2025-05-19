@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6 text-center">商品情報編集画面</h2>

    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow-md">
        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-bold mb-1">ID</label>
                <p>{{ $product->id }}</p>
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">商品名 <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">メーカー名 <span class="text-red-500">*</span></label>
                <select name="company_id" class="w-full border border-gray-300 p-2 rounded">
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $company->id == $product->company_id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">価格 <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                    class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">在庫数 <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                    class="w-full border border-gray-300 p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">コメント</label>
                <textarea name="comment" rows="3" class="w-full border border-gray-300 p-2 rounded">{{ old('comment', $product->comment) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">商品画像</label>
                <input type="file" name="image">
            </div>

            <div class="flex justify-center space-x-4 mt-6">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                    更新
                </button>
                <a href="{{ route('products.index') }}" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded">
                    戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection