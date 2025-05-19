<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザーログイン画面</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding: 100px;
        }

        h1 {
            font-size: 30px;
        }

        .form-group {
            margin: 20px 0;
        }

        input[type="email"],
        input[type="password"] {
            width: 300px;
            height: 40px;
            font-size: 16px;
            padding: 0 10px;
        }

        .btn {
            border: none;
            font-size: 18px;
            padding: 10px 30px;
            border-radius: 25px;
            margin: 0 10px;
            cursor: pointer;
        }

        .btn-login {
            background-color: #89f0ff;
        }

        .btn-register {
            background-color: #f79433;
        }

        .error-messages {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>ユーザーログイン画面</h1>

    {{-- エラーメッセージ表示 --}}
    @if ($errors->any())
        <div class="error-messages">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">アドレス</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">パスワード</label><br>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <a href="{{ route('register') }}">
                <button type="button" class="btn btn-register">新規登録</button>
            </a>
            <button type="submit" class="btn btn-login">ログイン</button>
        </div>
    </form>
</body>
</html>