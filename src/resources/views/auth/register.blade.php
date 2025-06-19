@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<form novalidate action="/register" method="post">
    @csrf
    <div class="form-menu" style="margin-top:96px;">

        <h1 class="form-menu__title" style="margin-top:0;margin-bottom:55px;">会員登録</h1>

        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">ユーザー名</h2>
                @error('name')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="name" type="text">
        </div>

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
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="password" type="password">
        </div>

        <div class="form-menu__group">
            <div class="form-menu__section-group">
            <h2 class="form-menu__section">確認用パスワード</h2>
            @error('password_confirmation')
                <span class="form-menu__error">{{ $message }}</span>
            @enderror
            </div>
            <input class="form-menu__input" style="margin-bottom:116px;" name="password_confirmation" type="password">
        </div>

        <input class="form-menu__button" type="submit" value="登録する">
        <div class="form-menu__link"><a href="/login">ログインはこちら</a></div>

    </div>
</form>
@endsection