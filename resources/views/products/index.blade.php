@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">商品一覧</h2>

    {{-- フラッシュメッセージ --}}
    <div id="ajax-message-area" class="mb-4">
        @if(session('success'))
            <div class="flash-message p-4 mb-4 bg-green-100 text-green-800 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash-message p-4 mb-4 bg-red-100 text-red-800 border border-red-300 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- 検索フォーム --}}
    <form id="search-form" class="flex flex-wrap md:flex-nowrap items-center gap-4 mb-6">
        <input type="text" name="keyword" value="{{ old('keyword', $searchKeyword) }}" placeholder="商品名で検索" class="border border-gray-300 rounded px-3 py-1 w-full md:w-1/4">
        <select name="company_id" class="border border-gray-300 rounded px-3 py-1 w-full md:w-1/4">
            <option value="">すべてのメーカー</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ $selectedCompany == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
            @endforeach
        </select>
        <input type="number" name="price_min" value="{{ old('price_min', $priceMin ?? '') }}" placeholder="価格（下限）" class="border border-gray-300 rounded px-3 py-1 w-full md:w-1/6">
        <input type="number" name="price_max" value="{{ old('price_max', $priceMax ?? '') }}" placeholder="価格（上限）" class="border border-gray-300 rounded px-3 py-1 w-full md:w-1/6">
        <input type="number" name="stock_min" value="{{ old('stock_min', $stockMin ?? '') }}" placeholder="在庫数（下限）" class="border border-gray-300 rounded px-3 py-1 w-full md:w-1/6">
        <input type="number" name="stock_max" value="{{ old('stock_max', $stockMax ?? '') }}" placeholder="在庫数（上限）" class="border border-gray-300 rounded px-3 py-1 w-full md:w-1/6">
        <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-1 rounded text-sm">検索</button>
    </form>

    {{-- 新規登録ボタン --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('products.create') }}" class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded text-sm font-medium text-black">新規登録</a>
    </div>

    {{-- 商品一覧テーブル --}}
    <table id="sortable-table" class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">商品名</th>
                <th class="px-4 py-2 border">価格</th>
                <th class="px-4 py-2 border">在庫</th>
                <th class="px-4 py-2 border">メーカー</th>
                <th class="px-4 py-2 border">操作</th>
            </tr>
        </thead>
        <tbody id="product-table-body">
            @foreach ($products as $product)
                <tr id="product-row-{{ $product->id }}">
                    <td class="border px-4 py-2">{{ $product->id }}</td>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">{{ $product->price }}</td>
                    <td class="border px-4 py-2">{{ $product->stock }}</td>
                    <td class="border px-4 py-2">{{ $product->company->name }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-500">詳細</a>
                        <button class="delete-button text-red-500" data-id="{{ $product->id }}">削除</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
$(function () {
    // 検索処理（JSONを受け取ってJSで描画）
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('products.index') }}",
            type: "GET",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response); // ← デバッグ用

                let tbody = $("#product-table-body");
                tbody.empty();

                // 修正：response.data を見る
                if (!response.data || response.data.length === 0) {
                    $('#ajax-message-area').html(
                        `<div class="p-4 mb-4 bg-red-100 text-red-800 border border-red-300 rounded">該当する商品は見つかりませんでした。</div>`
                    );
                    return;
                }

                // テーブルに反映
                response.data.forEach(function(product) {
                    tbody.append(`
                        <tr id="product-row-${product.id}">
                            <td class="border px-4 py-2">${product.id}</td>
                            <td class="border px-4 py-2">${product.name}</td>
                            <td class="border px-4 py-2">${product.price}</td>
                            <td class="border px-4 py-2">${product.stock}</td>
                            <td class="border px-4 py-2">${product.company ? product.company.name : ''}</td>
                            <td class="border px-4 py-2">
                                <a href="/products/${product.id}" class="text-blue-500">詳細</a>
                                <button class="delete-button text-red-500" data-id="${product.id}">削除</button>
                            </td>
                        </tr>
                    `);
                });

                bindDeleteEvents(); // 再バインド
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert("検索に失敗しました");
            }
        });
    });

    // 削除処理（非同期）
    function bindDeleteEvents() {
        $(".delete-button").off("click").on("click", function() {
            if (!confirm("本当に削除しますか？")) return;
            let id = $(this).data("id");
            $.ajax({
                url: `/products/${id}`,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function() {
                    $(`#product-row-${id}`).remove();
                    $('#ajax-message-area').html(
                        `<div class="p-4 mb-4 bg-green-100 text-green-800 border border-green-300 rounded">削除しました。</div>`
                    );
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("削除に失敗しました");
                }
            });
        });
    }

    bindDeleteEvents();
});
</script>
@endpush