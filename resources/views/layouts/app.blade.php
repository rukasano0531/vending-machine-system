<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>販売管理システム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- ✅ jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- ✅ tablesorter（integrity削除） --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>

    {{-- ✅ Viteで読み込むCSSとJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ 各ビューごとの追加スクリプト --}}
    @stack('scripts')
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <div class="min-h-screen">

        {{-- ナビゲーションバー --}}
        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-xl font-bold">販売管理システム</h1>
            <div class="text-sm text-gray-600">
                @auth
                    {{ Auth::user()->name }}（{{ Auth::user()->email }}）
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                        @csrf
                        <button class="text-blue-500 hover:underline">ログアウト</button>
                    </form>
                @endauth
            </div>
        </div>

        <main class="p-6">

            {{-- ✅ フラッシュメッセージ --}}
            @if (session('success'))
                <div class="flash-message mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="flash-message mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- メインコンテンツ --}}
            @yield('content')
        </main>
    </div>

    {{-- ✅ フラッシュメッセージ自動非表示スクリプト --}}
    <script>
        $(function () {
            setTimeout(function () {
                $('.flash-message').fadeOut('slow');
            }, 3000); // 3秒後にフェードアウト
        });
    </script>
</body>
</html>