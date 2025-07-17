<form action="/search" method="get">
    @csrf
    <input class="header-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ $searchWord ?? '' }}">
</form>
<div class="header-menu">
    @if (Auth::check())
        <form action="/logout" method="post">
            @csrf
            <button class="header-menu__logout">ログアウト</button>
        </form>
    @else
        <a class="header-menu__link" href="/login" class="test-class">ログイン</a>
    @endif
    <a class="header-menu__link" href="/mypage/?page=sell">マイページ</a>
    <button class="header-menu__button" onclick="location.href='/sell'">出品</button>
</div>