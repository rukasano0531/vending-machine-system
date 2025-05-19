<nav class="bg-white border-b border-gray-200 shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        {{-- ロゴ（左側） --}}
        <div class="text-xl font-bold text-gray-800">
            <a href="{{ route('products.index') }}">販売管理システム</a>
        </div>

        {{-- メニュー（右側） --}}
        <div class="flex items-center space-x-4 text-sm text-gray-600">
            @auth
                <span>{{ Auth::user()->name }}（{{ Auth::user()->email }}）</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-blue-500 hover:underline">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">ログイン</a>
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">新規登録</a>
            @endauth
        </div>
    </div>
</nav>