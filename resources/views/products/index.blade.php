@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">商品一覧</h2>

    {{-- 新規登録ボタン --}}
    <div class="flex justify-end mb-4">
        <a
            href="{{ route('products.create') }}"
            class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded text-sm font-medium text-black"
        >
            新規登録
        </a>
    </div>

    {{-- 商品一覧テーブル --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">商品画像</th>
                    <th class="px-4 py-2 border">商品名</th>
                    <th class="px-4 py-2 border">価格</th>
                    <th class="px-4 py-2 border">在庫数</th>
                    <th class="px-4 py-2 border">メーカー</th>
                    <th class="px-4 py-2 border">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="text-center">
                    <td class="px-4 py-2 border">{{ $product->id }}</td>
                    <td class="px-4 py-2 border">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-20 h-auto mx-auto">
                        @else
                            画像なし
                        @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $product->name }}</td>
                    <td class="px-4 py-2 border">¥{{ number_format($product->price) }}</td>
                    <td class="px-4 py-2 border">{{ $product->stock }}</td>
                    <td class="px-4 py-2 border">{{ $product->company->name }}</td>
                    <td class="px-4 py-2 border">
                        <div class="flex justify-center space-x-2">
                            <a
                                href="{{ route('products.show', $product->id) }}"
                                class="bg-sky-300 hover:bg-sky-400 px-3 py-1 rounded text-sm font-medium text-black"
                            >
                                詳細
                            </a>
                            <a
                                href="{{ route('products.edit', $product->id) }}"
                                class="bg-yellow-300 hover:bg-yellow-400 px-3 py-1 rounded text-sm font-medium text-black"
                            >
                                編集
                            </a>
                            <form
                                action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                onsubmit="return confirm('本当に削除しますか？');"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm font-medium text-white"
                                >
                                    削除
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection