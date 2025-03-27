@extends('layouts.app')

@section('content')
<div style="text-align: center; margin-top: 50px;">
    <h2>ユーザーログイン画面</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <input type="email" name="email" placeholder="アドレス" required style="display: block; width: 300px; margin: 10px auto; padding: 10px;">
        </div>

        <div>
            <input type="password" name="password" placeholder="パスワード" required style="display: block; width: 300px; margin: 10px auto; padding: 10px;">
        </div>

        <div style="display: flex; justify-content: center; gap: 20px;">
            <button type="submit" style="background-color: skyblue; padding: 10px 20px; border-radius: 20px;">ログイン</button>
            <a href="{{ route('register') }}" style="background-color: orange; padding: 10px 20px; border-radius: 20px; text-decoration: none; color: black;">新規登録</a>
        </div>
    </form>
</div>
@endsection
