@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">ユーザー新規登録画面</h2>

    <form method="POST" action="{{ route('register') }}" class="register-form">
        @csrf

        <div class="form-group">
            <label for="name">名前</label>
            <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm">パスワード確認</label>
            <input id="password-confirm" type="password" name="password_confirmation" required>
        </div>

        <div class="button-group">
            <button type="submit" class="register-btn">新規登録</button>
            <a href="{{ route('login') }}" class="back-btn">戻る</a>
        </div>
    </form>
</div>

<style>
    .container {
        text-align: center;
        max-width: 400px;
        margin: auto;
    }
    .form-group {
        margin-bottom: 15px;
    }
    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .error-message {
        color: red;
        font-size: 0.9em;
    }
    .button-group {
        display: flex;
        justify-content: space-between;
    }
    .register-btn {
        background-color: orange;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
    }
    .back-btn {
        background-color: skyblue;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
</style>
@endsection
