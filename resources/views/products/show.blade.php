@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">商品情報詳細画面</h2>

    <div class="border border-gray-400 p-8 max-w-2xl mx-auto rounded-lg shadow">
        <table class="table-auto w-full text-base">
            <tr class="align-top">
                <th class="text-left font-semibold w-32">ID</th>
                <td><em>{{ $product->id }}</em></td>
            </tr>
            <tr class="align-top">
                <th class="text-left font-semibold">商品画像</th>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-40 border p-1">
                    @else
                        画像なし
                    @endif
                </td>
            </tr>
            <tr>
                <th class="text-left font-semibold">商品名</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th class="text-left font-semibold">メーカー</th>
                <td>{{ $product->company->name }}</td>
            </tr>
            <tr>
                <th class="text-left font-semibold">価格</th>
                <td>¥{{ number_format($product->price) }}</td>
            </tr>
            <tr>
                <th class="text-left font-semibold">在庫数</th>
                <td>{{ $product->stock }}</td>
            </tr>
            <tr class="align-top">
                <th class="text-left font-semibold">コメント</th>
                <td>
                    <textarea rows="3" class="border rounded p-2 w-full bg-gray-100" readonly>{{ $product->comment ?? 'なし' }}</textarea>
                </td>
            </tr>
        </table>

        <div class="mt-8 flex justify-center space-x-4">
            <a href="{{ route('products.edit', $product->id) }}"
               class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded">
                編集
            </a>
            <a href="{{ route('products.index') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded">
                戻る
            </a>
        </div>
    </div>
</div>
@endsection