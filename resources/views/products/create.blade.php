@extends('layouts.app')

@section('content')
<style>
    /* 全体コンテナ */
    .form-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        border: 1px solid #333;
        border-radius: 8px;
        background-color: #fff;
    }
    /* 各フォーム行 */
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    /* ラベル */
    .form-group label {
        width: 140px;
        font-weight: bold;
    }
    /* 入力欄 */
    .form-group input,
    .form-group select,
    .form-group textarea {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    /* テキストエリア高めに */
    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }
    /* 必須マーク */
    .required {
        color: red;
        margin-left: 4px;
    }
    /* ボタン群 */
    .form-buttons {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 30px;
    }
    /* 新規登録ボタン */
    .btn-register {
        background-color: #FFA726;
        color: #fff;
        padding: 10px 30px;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        cursor: pointer;
    }
    .btn-register:hover {
        background-color: #FB8C00;
    }
    /* 戻るボタン */
    .btn-back {
        background-color: #4FC3F7;
        color: #fff;
        padding: 10px 30px;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        line-height: 1;
    }
    .btn-back:hover {
        background-color: #03A9F4;
    }
</style>

<div class="form-container">
    <h2 class="text-center mb-6">商品新規登録画面</h2>

    {{-- バリデーションエラー --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品名 --}}
        <div class="form-group">
            <label for="name">商品名<span class="required">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name') }}" 
                required
            >
        </div>

        {{-- メーカー --}}
        <div class="form-group">
            <label for="company_id">メーカー名<span class="required">*</span></label>
            <select name="company_id" id="company_id" required>
                <option value="">-- メーカーを選択してください --</option>
                @foreach ($companies as $company)
                    <option 
                        value="{{ $company->id }}" 
                        {{ old('company_id') == $company->id ? 'selected' : '' }}
                    >{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- 価格 --}}
        <div class="form-group">
            <label for="price">価格<span class="required">*</span></label>
            <input 
                type="number" 
                name="price" 
                id="price" 
                value="{{ old('price', 0) }}" 
                min="0" 
                required
            >
        </div>

        {{-- 在庫数 --}}
        <div class="form-group">
            <label for="stock">在庫数<span class="required">*</span></label>
            <input 
                type="number" 
                name="stock" 
                id="stock" 
                value="{{ old('stock', 0) }}" 
                min="0" 
                required
            >
        </div>

        {{-- コメント --}}
        <div class="form-group">
            <label for="comment">コメント</label>
            <textarea name="comment" id="comment">{{ old('comment') }}</textarea>
        </div>

        {{-- 画像 --}}
        <div class="form-group">
            <label for="image">商品画像</label>
            <input type="file" name="image" id="image" accept="image/*">
        </div>

        {{-- ボタン --}}
        <div class="form-buttons">
            <button type="submit" class="btn-register">新規登録</button>
            <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
        </div>
    </form>
</div>
@endsection