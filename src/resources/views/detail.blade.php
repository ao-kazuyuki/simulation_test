@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')
    @php
        $path = 'storage/user_' . $item->user_id . '/item_' . $item->id . '/';
        $file = glob($path . '*');
        if(!empty($file)){
            $path .= basename($file[0]);
        }
        $brand = 'ブランド未指定品';
        if(isset($item->brand)){
            $brand = $item->brand;
        }
    @endphp
    <div class="detail-group">
        <!-- 商品画像 -->
        <img class="detail-img" src="{{ asset( $path ) }}">
        <!-- 商品詳細 -->
        <div class="detail-explanation">
            <!-- 商品名・ブランド名・商品価格 -->
            <h1 class="detail-section">{{ $item->name }}</h1>
            <h4 class="detail-brand">{{ $brand }}</h4>
            <div class="detail__price-group">
                <span class="detail-price__currency">￥</span>
                <span class="detail-price__value">{{ number_format($item->price) }}</span>
                <span class="detail-price__tax">(税込)</span>
            </div>
            <!-- いいねアイコン・コメントアイコン -->
            <div class="detail__icon-group">
                <div class="detail__likes-group">
                    <form action="{{ '/item/' . $item->id . '/like' }}" method="post">
                    @csrf
                        @isset($imgPath)
                            <input class="detail__icon-img" type="image" src="{{ asset( $imgPath ) }}">
                        @else
                            <input class="detail__icon-img" type="image" src="{{ asset( 'img/star.png' ) }}">
                        @endisset
                    </form>
                    <div class="detail-counter">{{ $likeCount }}</div>
                </div>
                <div class="detail__talks-group">
                    <img class="detail__icon-img" src="{{ asset('img/talk.png') }}">
                    <div class="detail-counter">{{ $comments->count() }}</div>
                </div>
            </div>
            <!-- 購入手続きボタン -->
            <button class="detail__buy-button" type="button" onclick="window.location.href='{{ '/purchase/' . $item->id }}';">購入手続きへ</button>
            <!-- 商品説明 -->
            <h2 class="detail-section__middle">商品説明</h2>
            <div class="detail-item__explanation">{!! nl2br(e($item->explanation)) !!}</div>
            <!-- 商品の情報(カテゴリー・商品の状態) -->
            <h2 class="detail-section__middle">商品の情報</h2>
            <div class="detail__flex-style">
                <h3 class="detail-section__small">カテゴリー</h3>
                <div class="detail__category-group">
                    @foreach($item->categories as $category)
                        <div class="ditail-category">{{ $category->content }}</div>
                    @endforeach
                </div>
            </div>
            <div class="detail__flex-style">
                <h3 class="detail-section__small">商品の状態</h3>
                <div class="detail-section__small--text">{{ $item->condition->content }}</div>
            </div>
            <!-- コメント一覧 -->
            <div class="detail-section__middle--gray">{{ 'コメント(' . $comments->count() . ')' }}</div>
            @foreach($comments as $comment)
                <div class="detail__flex-style">
                    <div class="detail__user-icon"></div>
                    <div class="detail__user-name">{{ $comment->user->name }}</div>
                </div>
                <div class="detail__comment-area">
                    <p>{!! nl2br(e($comment->content)) !!}</p>
                </div>
            @endforeach
            <!-- コメント記入欄 -->
            <form action="{{ '/item/' . $item->id . '/comment' }}" method="post">
                @csrf
                <h3 class="detail__comment-section">商品へのコメント</h3>
                <textarea name="content" class="detail-textarea"></textarea>
                <div class="form-error">
                    @error('content')
                        {{ $message }}
                    @enderror
                </div>
                <button type="submit" class="detail__comment-button">コメントを送信する</button>
            </form>
        </div>
    </div>
@endsection