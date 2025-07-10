@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')

<div class="mypage-header">
    <div class="mypage-header__user-icon"></div>
    <div class="mypage-header__user-name">{{ $user->name }}</div>
    <a href="/mypage/profile" class="mypage-header__edit-button">プロフィールを編集</a>
</div>

<div class="item-menu">
    @isset($request)
        @if($request->page=='sell')
            <div class="item-menu__link--strong"><a href="/mypage/?page=sell">出品した商品</a></div>
            <div class="item-menu__link"><a href="/mypage/?page=buy">購入した商品</a></div>
        @elseif($request->page=='buy')
            <div class="item-menu__link"><a href="/mypage/?page=sell">出品した商品</a></div>
            <div class="item-menu__link--strong"><a href="/mypage/?page=buy">購入した商品</a></div>
        @endif
    @endisset
</div>

<div class="item-lists">
    @foreach($items as $item)
        @php
            $url = '/item/' . $item->id;
            $path = 'storage/user_' . $item->user_id . '/item_' . $item->id . '/img_src.jpg';
        @endphp
    <a href="{{ $url }}" class="item-lists--group">
        <div class="item-lists--image">
            <img src="{{ asset( $path ) }}" width="290" height="290">
            @if($item->buy)
                <div class="item-sold">Sold</div>
            @endif
        </div>
        <div class="item-lists--name">{{ $item->name }}</div> 
    </a>
    @endforeach
</div>

@endsection