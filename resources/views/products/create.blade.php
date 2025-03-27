@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品新規登録画面</h2>

    <!-- バリデーションエラーメッセージの表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品名 -->
        <div class="form-group">
            <label for="name">商品名 <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- メーカー名 -->
        <div class="form-group">
            <label for="company_id">メーカー名 <span class="text-danger">*</span></label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">メーカーを選択してください</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- 価格 -->
        <div class="form-group">
            <label for="price">価格 <span class="text-danger">*</span></label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        <!-- 在庫数 -->
        <div class="form-group">
            <label for="stock">在庫数 <span class="text-danger">*</span></label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>

        <!-- コメント -->
        <div class="form-group">
            <label for="comment">コメント</label>
            <textarea name="comment" id="comment" class="form-control"></textarea>
        </div>

        <!-- 商品画像 -->
        <div class="form-group">
            <label for="image">商品画像</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <!-- 登録ボタン -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">新
