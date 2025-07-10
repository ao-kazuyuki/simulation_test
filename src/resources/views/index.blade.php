@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')

<div class="item-menu">

    @isset($request)
        @if($request->page=='mylist')
            <div class="item-menu__link"><a href="/">おすすめ</a></div>
            <div class="item-menu__link--strong"><a href="/?page=mylist">マイリスト</a></div>
        @endif
    @else
        <div class="item-menu__link--strong"><a href="/">おすすめ</a></div>
        <div class="item-menu__link"><a href="/?page=mylist">マイリスト</a></div>
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