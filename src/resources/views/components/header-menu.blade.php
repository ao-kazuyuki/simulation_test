<div class="header-input__area">
    <input class="header-input" type="text" placeholder="なにをお探しですか？">
</div>
<div class="header-menu__area">
    @if (Auth::check())
        <form action="/logout" method="post">
            @csrf
            <button class="header-menu__area--logout">ログアウト</button>
        </form>
    @else
        <div class="header-menu__area--link"><a href="/login">ログイン</a></div>
    @endif        
    <div class="header-menu__area--link"><a href="">マイページ</a></div>
    <input class="header-menu__area--button" type="button" value="出品">
</div>