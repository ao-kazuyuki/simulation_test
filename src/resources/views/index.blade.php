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
    <div class="item-lists--group">
        <div class="item-lists--image"></div>
        <div class="item-lists--name">商品名</div> 
    </div>
    <div class="item-lists--group">
        <div class="item-lists--image"></div>
        <div class="item-lists--name">商品名</div> 
    </div>
    <div class="item-lists--group">
        <div class="item-lists--image"></div>
        <div class="item-lists--name">商品名</div> 
    </div>
    <div class="item-lists--group">
        <div class="item-lists--image"></div>
        <div class="item-lists--name">商品名</div> 
    </div>
    <div class="item-lists--group">
        <div class="item-lists--image"></div>
        <div class="item-lists--name">商品名</div> 
    </div>
    <div class="item-lists--group">
        <div class="item-lists--image"></div>
        <div class="item-lists--name">商品名</div> 
    </div>
    <div class="item-lists--group">
        <div class="item-lists--image"></div>
        <div class="item-lists--name">商品名</div> 
    </div>
</div>

@endsection