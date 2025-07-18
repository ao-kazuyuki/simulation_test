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
    <div class="mypage-header__user-group">
        <div class="mypage-header__user-icon"></div>
        <div>
            <h1 class="mypage-header__user-name">{{ $user->name }}</h1>
            <a href="/mypage/profile" class="mypage-header__edit-button tablet">プロフィールを編集</a>
        </div>
    </div>
    <a href="/mypage/profile" class="mypage-header__edit-button pc">プロフィールを編集</a>
</div>

<div class="item-menu">
    @isset($request)
        @if($request->page=='sell')
            <a class="item-menu__link--strong" href="/mypage/?page=sell">出品した商品</a>
            <a class="item-menu__link" href="/mypage/?page=buy">購入した商品</a>
        @elseif($request->page=='buy')
            <a class="item-menu__link" href="/mypage/?page=sell">出品した商品</a>
            <a class="item-menu__link--strong" href="/mypage/?page=buy">購入した商品</a>
        @endif
    @endisset
</div>

<div class="item-lists">
    @foreach($items as $item)
        @php
            $url = '/item/' . $item->id;
            $path = 'storage/user_' . $item->user_id . '/item_' . $item->id . '/';
            $file = glob($path . '*');
            if(!empty($file)){
                $path .= basename($file[0]);
            }
        @endphp
        <a href="{{ $url }}" class="item-group">
            <div class="item-image">
                <img src="{{ asset( $path ) }}">
                @if($item->buy)
                    <div class="item-sold">Sold</div>
                @endif
            </div>
            <span class="item-name">{{ $item->name }}</span> 
        </a>
    @endforeach
</div>
@endsection