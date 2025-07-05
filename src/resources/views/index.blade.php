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
    <div class="item-menu__link">おすすめ</div>
    <div class="item-menu__link">マイリスト</div>
</div>

<div class="item-lists">
    @foreach($items as $item)
        @php
            $url = '/item/' . $item->id;
            $path = 'storage/user_' . $item->user_id . '/item_' . $item->id . '/img_src.jpg';
        @endphp
    <a href="{{ $url }}" class="item-lists--group">
        <div class="item-lists--image"><img src="{{ asset( $path ) }}" width="290" height="290"></div>
        <div class="item-lists--name">{{ $item->name }}</div> 
    </a>
    @endforeach
</div>

@endsection