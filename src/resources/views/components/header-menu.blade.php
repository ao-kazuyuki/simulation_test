<!-- 商品検索欄 -->
<form action="/search" method="get">
    @csrf
    <input id="search" class="header-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ $searchWord ?? '' }}">
</form>

<!-- タブレット向けハンバーガーメニュー -->
<div id="open" class="header-hamburger__open-btn">
    <div class="header-hamburger__open-line"></div>
    <div class="header-hamburger__open-line"></div>
    <div class="header-hamburger__open-line"></div>
</div>
<div id="close" class="header-hamburger__close-btn">
    <span>×</span>
    <ul class="hamburger-list">
        @if (Auth::check())
            <li class="hamburger-list__menu item-top">
                <form action="/logout" method="post">
                    @csrf
                    <button class="humburger-btn">ログアウト</button>
                </form>
            </li>
        @else
            <li class="hamburger-list__menu item-top">
                <a class="hamburger-link" href="/login">ログイン</a>
            </li>
        @endif
        <li class="hamburger-list__menu item-middle"><a class="hamburger-link" href="/mypage/?page=sell">マイページ</a></li>
        <li class="hamburger-list__menu item-bottom"><a class="hamburger-link" href='/sell'>出品</a></li>
    </ul>
</div>

<!-- PC向けメニュー -->
<div class="header-menu">
    @if (Auth::check())
        <form action="/logout" method="post">
            @csrf
            <button class="header-menu__logout">ログアウト</button>
        </form>
    @else
        <a class="header-menu__link" href="/login">ログイン</a>
    @endif
    <a class="header-menu__link" href="/mypage/?page=sell">マイページ</a>
    <button class="header-menu__button" onclick="location.href='/sell'">出品</button>
</div>

<!-- レスポンシブ処理 -->
<script>
    const pcMinWidth = 1400;
    const tabletMaxWidth = 850;
    const navOpen = document.getElementById('open');
    const navClose = document.getElementById('close');
    const searchInput = document.getElementById('search');
    if(window.innerWidth < tabletMaxWidth){
        searchInput.placeholder = '商品を検索';
    }
    let enableOpen = true;
    let enableClose = false;
    navOpen.addEventListener('click', function(){
        if(enableOpen){
            navOpen.style.display = "none";
            navClose.style.display = "block";
            enableOpen = false;
            enableClose = true;
        }
    });
    navClose.addEventListener('click', function(){
        if(enableClose){
            navOpen.style.display = "block";
            navClose.style.display = "none";
            enableOpen = true;
            enableClose = false;
        }
    });
    window.addEventListener('resize', function(){
        if(window.innerWidth >= pcMinWidth){
            if(enableOpen){
                navOpen.style.display = "none";
            }
            if(enableClose){
                navClose.style.display = "none";
            }
        }else{
            if(enableOpen){
                navOpen.style.display = "block";
            }
            if(enableClose){
                navClose.style.display = "block";
            }
        }
        if(window.innerWidth < tabletMaxWidth){
            searchInput.placeholder = '商品を検索';
        }else{
            searchInput.placeholder = 'なにをお探しですか？';
        }
    });
</script>