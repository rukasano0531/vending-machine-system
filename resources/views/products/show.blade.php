@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品情報詳細画面</h2>

    <div class="card p-4">
        <table class="table">
            <tr>
                <th>ID</th>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th>商品画像</th>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" width="150">
                    @else
                        画像なし
                    @endif
                </td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>メーカー</th>
                <td>{{ $product->company->name }}</td>
            </tr>
            <tr>
                <th>価格</th>
                <td>¥{{ number_format($product->price) }}</td>
            </tr>
            <tr>
                <th>在庫数</th>
                <td>{{ $product->stock }}</td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>{{ $product->comment ?? 'なし' }}</td>
            </tr>
        </table>

        <div class="mt-3">
            <!-- 編集ボタン -->
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">編集</a>

            <!-- 戻るボタン -->
            <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
        </div>
    </div>
</div>
@endsection


Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

