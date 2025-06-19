<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header-item__group">
            <div class="header-logo__area">
                <img class="header-logo" src="{{ asset('img/logo.svg') }}">
            </div>
            @yield('header-menu')
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>