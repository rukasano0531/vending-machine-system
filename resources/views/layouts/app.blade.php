<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>販売管理システム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        {{-- メインの @section('content') --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>
</body>
</html>