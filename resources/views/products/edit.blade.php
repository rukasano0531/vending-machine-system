@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品情報編集画面</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table border="1">
            <tr>
                <td><strong><em>ID</em></strong></td>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <td>商品名 <span style="color: red;">*</span></td>
                <td><input type="text" name="name" value="{{ old('name', $product->name) }}" required></td>
            </tr>
            <tr>
                <td>メーカー名 <span style="color: red;">*</span></td>
                <td>
                    <select name="company_id" required>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>価格 <span style="color: red;">*</span></td>
                <td><input type="number" name="price" value="{{ old('price', $product->price) }}" required></td>
            </tr>
            <tr>
                <td>在庫数 <span style="color: red;">*</span></td>
                <td><input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required></td>
            </tr>
            <tr>
                <td>コメント</td>
                <td><textarea name="comment">{{ old('comment', $product->comment) }}</textarea></td>
            </tr>
            <tr>
                <td>商品画像</td>
                <td>
                    <input type="file" name="image">
                    @if ($product->image_path)
                        <div>
                            <img src="{{ asset('storage/' . $product->image_path) }}" width="100">
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        <button type="submit" style="background-color: orange;">更新</button>
        <a href="{{ route('products.show', $product->id) }}" style="background-color: lightblue;">戻る</a>
    </form>
</div>
@endsection
