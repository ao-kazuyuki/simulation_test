@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<form class="login-form" novalidate action="/login" method="post">
    @csrf
    <h1 class="login-form__title">ログイン</h1>
    <!-- メールアドレス -->
    <div>
        <h2 class="login-section">メールアドレス</h2>
        <input class="login-input" name="email" type="email" value="{{ old('email') }}">
        <div class="form-error">
            @error('email')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- パスワード -->
    <div>
        <h2 class="login-section">パスワード</h2>
        <input class="login-input" name="password" type="password">
        <div class="form-error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- ログインボタン -->
    <input class="login-button" type="submit" value="ログインする">
</form>

<!-- 会員登録へのリンク -->
<div class="link-area">
    <a href="/register">会員登録はこちら</a>
</div>
@endsection