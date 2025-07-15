@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')
<form class="address-form" action="{{ '/purchase/' . $item->id }}" method="post">
    @csrf
    @method('PATCH')
    <h1 class="address-form__title">住所の変更</h1>
    <!-- 郵便番号 -->
    <div>
        <h2 class="address-section">郵便番号</h2>
        <input class="address-input" name="post_code" type="text" value="{{ old('post_code', $request->post_code ?? $user->post_code ) }}">
        <div class="form-error">
            @error('post_code')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- 住所 -->
    <div>
        <h2 class="address-section">住所</h2>
        <input class="address-input" name="address" type="text" value="{{ old('address', $request->address ?? $user->address ) }}">
        <div class="form-error">
            @error('address')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- 建物名 -->
    <div>
        <h2 class="address-section">建物名</h2>
        <input class="address-input" name="building" type="text"  value="{{ old('building', $request->building ?? $user->building ) }}">
    </div>
    <!-- 支払い方法の情報を保持 -->
    <input type="hidden" name="paymentValue" value="{{ $request->payment }}">
    <!-- 更新ボタン -->
    <input class="address-button" type="submit" value="更新する">
</form>
@endsection