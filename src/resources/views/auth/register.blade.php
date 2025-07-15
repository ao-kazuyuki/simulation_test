@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<form class="register-form" novalidate action="/register" method="post">
    @csrf
    <h1 class="register-form__title">会員登録</h1>
    <!-- ユーザー名 -->
    <div>
        <h2 class="register-section">ユーザー名</h2>
        <input class="register-input" name="name" type="text" value="{{ old('name') }}">
        <div class="form-error">
            @error('name')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- メールアドレス -->
    <div>
        <h2 class="register-section">メールアドレス</h2>
        <input class="register-input" name="email" type="email" value="{{ old('email') }}">
        <div class="form-error">
            @error('email')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- パスワード -->
    <div>
        <h2 class="register-section">パスワード</h2>
        <input class="register-input" name="password" type="password">
        <div class="form-error">
            @error('password')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- 確認用パスワード -->
    <div>
        <h2 class="register-section">確認用パスワード</h2>
        <input class="register-input" name="password_confirmation" type="password">
        <div class="form-error">
            @error('password_confirmation')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- 登録ボタン -->
    <input class="register-button" type="submit" value="登録する">
</form>

<!-- ログインへのリンク -->
<div class="link-area">
    <a href="/login">ログインはこちら</a>
</div>
@endsection