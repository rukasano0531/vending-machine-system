@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品一覧画面</h2>
    <form method="GET" action="{{ route('products.index') }}" class="mb-3">
        <input type="text" name="keyword" placeholder="検索キーワード" value="{{ $searchKeyword ?? '' }}">
        <select name="company_id">
            <option value="">メーカー名</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ $selectedCompany == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">検索</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" width="50"></td>
                <td>{{ $product->name }}</td>
                <td>¥{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->name }}</td>
                <td>
                    <a href="#" class="btn btn-info">詳細</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $products->links() }}
    </div>
</div>
@endsection
