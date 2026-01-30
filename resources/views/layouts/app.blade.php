<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- 外部のCSSファイルを読み込むためのコード -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- 共通CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> <!-- ヘッダーー（共通） -->
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}"
                    >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- ナビゲーションリンク：ログインユーザー名の左側に表示 -->
                        @if (!request()->routeIs('login', 'register')) <!-- Homeとマイページはログイン後に画面でのみ表示 -->
                            <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('mypage.user_index') }}">マイページ</a>
                            </li>
                        @endif

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @else
                            <li class="nav-item"> <!-- ユーザー名を表示 -->
                                <span class="nav-link">
                                    ログインユーザー：{{ Auth::user()->name }}
                                </span>
                            </li>

                            <li class="nav-item"> <!-- ログアウトリンク -->
                                <a
                                    class="btn btn-danger ms-2"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('ログアウト') }}
                                </a>

                                <form
                                    id="logout-form"
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    class="d-none">
                                @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <!-- 成功メッセージ -->
            @if (session('success'))
                <div class="alert alert-success container">
                    {{ session('success') }}
                </div>
            @endif

            <!-- エラーメッセージ -->
            @if (session('error'))
                <div class="alert alert-danger container">
                    {{ session('error') }}
                </div>
            @endif

            <!-- バリデーションエラーの表示 -->
            @if ($errors->any())
                <div class="alert alert-danger container">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('content')
        </main>

        <footer class="navbar navbar-expand-md navbar-light bg-light border-top"> <!-- フッター（共通） -->
            <div class="container justify-content-center">
                <ul class="navbar-nav">
                @if (!request()->routeIs('login', 'register'))  <!-- Homeとマイページはログイン後に画面でのみ表示 -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">お問い合わせ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mypage.user_index') }}">マイページ</a>
                        </li>
                    @endif
                </ul>
            </div>
        </footer>

    </div>
</body>
</html>
