@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">商品一覧</h2>

    {{-- フラッシュメッセージ --}}
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

    {{-- 検索フォーム（Ajax用） --}}
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

    {{-- Ajaxメッセージ表示用 --}}
    <div id="ajax-message-area" class="mb-4"></div>

    {{-- 新規登録ボタン --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('products.create') }}" class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded text-sm font-medium text-black">新規登録</a>
    </div>

    {{-- 商品一覧テーブル --}}
    <div id="product-list">
        @include('products.partials.list', ['products' => $products])
    </div>

    {{-- 検索結果が空のときだけエラーメッセージ表示 --}}
    @if(request()->hasAny(['keyword', 'company_id', 'price_min', 'price_max', 'stock_min', 'stock_max']) && $products->isEmpty())
        <div id="no-results-message" class="mt-4 text-red-600 font-semibold">
            該当する商品は見つかりませんでした。
        </div>
    @endif

    {{-- ページネーション --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
    $(function () {
        function initializeTable() {
            if ($.fn.tablesorter) {
                $("#sortable-table").tablesorter({
                    sortList: [[0, 1]]
                });
            } else {
                console.warn("tablesorterがロードされていません");
            }
        }

        function bindDeleteEvents() {
            $('.delete-button').off('click').on('click', function () {
                if (!confirm('本当に削除しますか？')) return;

                const productId = $(this).data('id');
                const row = $('#product-row-' + productId);
                const baseUrl = "{{ url('') }}";

                $.ajax({
                    url: `${baseUrl}/products/${productId}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        row.fadeOut(300, function () {
                            $(this).remove();
                        });
                        $('#ajax-message-area').html('<div class="flash-message p-4 mb-4 bg-green-100 text-green-800 border border-green-300 rounded">{{ config('message.delete_success') }}</div>');
                        setTimeout(() => $('.flash-message').fadeOut('slow'), 3000);
                    },
                    error: function (xhr) {
                        alert('削除に失敗しました');
                    }
                });
            });
        }

        initializeTable();
        bindDeleteEvents();

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: "{{ route('products.index') }}",
                type: 'GET',
                data: formData,
                dataType: 'html',
                success: function (response) {
                    const newTable = $(response).find('#product-list').html();
                    $('#product-list').html(newTable);
                    initializeTable();
                    bindDeleteEvents();

                    const flashMessage = $(response).find('.flash-message').text();
                    if (flashMessage) {
                        $('#ajax-message-area').html(
                            `<div class="flash-message p-4 mb-4 bg-red-100 text-red-800 border border-red-300 rounded">${flashMessage}</div>`
                        );
                        setTimeout(() => $('.flash-message').fadeOut('slow'), 3000);
                    }

                    const noResults = $(response).find('#no-results-message').html();
                    if (noResults) {
                        $('#ajax-message-area').html(
                            `<div class="p-4 mb-4 bg-red-100 text-red-800 border border-red-300 rounded">${noResults}</div>`
                        );
                        setTimeout(() => $('.flash-message').fadeOut('slow'), 3000);
                    }
                },
                error: function () {
                    alert('検索に失敗しました');
                }
            });
        });
    });
    </script>
@endpush