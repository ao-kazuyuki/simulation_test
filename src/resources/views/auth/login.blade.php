@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<form novalidate action="/login" method="post">
    @csrf
    <div class="form-menu" style="margin-top:118px;">

        <h1 class="form-menu__title" style="margin-top:0;margin-bottom:53px;">ログイン</h1>

        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">メールアドレス</h2>
                @error('email')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="email" type="email">
        </div>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">パスワード</h2>
                @error('password')
                    <div class="form-menu__error">{{ $message }}</div>
                @enderror
            </div>
            <input class="form-menu__input" style="margin-bottom:80px;" name="password" type="password">            
        </div>

        <input class="form-menu__button" type="submit" value="ログインする">
        <div class="form-menu__link"><a href="/register">会員登録はこちら</a></div>

    </div>
</form>
@endsection