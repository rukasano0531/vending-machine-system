@extends('layouts.app')

@section('content')
<div style="text-align: center; margin-top: 50px;">
    <h2>ダッシュボード</h2>
    <p>ようこそ、{{ Auth::user()->name }} さん！</p>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
@endsection
