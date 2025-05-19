<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー新規登録画面</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding-top: 80px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 40px;
        }

        input[type="email"],
        input[type="password"] {
            width: 400px;
            padding: 15px;
            font-size: 18px;
            margin: 15px auto;
            display: block;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 30px;
        }

        .register-btn,
        .back-btn {
            padding: 12px 40px;
            font-size: 18px;
            border: 1px solid #000;
            border-radius: 25px;
            cursor: pointer;
        }

        .register-btn {
            background-color: orange;
        }

        .back-btn {
            background-color: aqua;
        }
    </style>
</head>
<body>
    <h1>ユーザー新規登録画面</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="password" name="password" placeholder="パスワード" required>
        <input type="email" name="email" placeholder="アドレス" required>

        <div class="button-container">
            <button type="submit" class="register-btn">新規登録</button>
            <button type="button" onclick="history.back()" class="back-btn">戻る</button>
        </div>
    </form>
</body>
</html>