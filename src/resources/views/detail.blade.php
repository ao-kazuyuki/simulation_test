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
        $path = 'storage/user_' . $item->user_id . '/item_' . $item->id . '/img_src.jpg';
        $brand = 'ブランド未指定品';
        if(isset($item->brand)){
            $brand = $item->brand;
        }
    @endphp
    <div class="detail-content__group">
        <img class="detail-content__img" src="{{ asset( $path ) }}" width="600" height="600">        
        <div class="detail-content__explanation">
            <div class="detail-content__name">{{ $item->name }}</div>
            <div class="detail-content__brand">{{ $brand }}</div>
            <div class="detail-content__price-group">
                <div class="detail-content__currency">￥</div>
                <div class="detail-content__price">{{ number_format($item->price) }}</div>
                <div class="detail-content__tax">(税込)</div>
            </div>
            <div class="detail-content__icon-group">
                <div class="detail-content__likes-group">
                    <img src="{{ asset('img/star.png') }}">
                    <div class="detail-content__total-count">0</div>
                </div>
                <div class="detail-content__talks-group">
                    <img src="{{ asset('img/talk.png') }}">
                    <div class="detail-content__total-count">{{ $comments->count() }}</div>
                </div>
            </div>
            <button type="button" class="detail-content__button">購入手続きへ</button>
            <div class="detail-content__section">商品説明</div>
            <div class="detail-content__item-explanation">{{ $item->explanation }}</div>
            <div class="detail-content__section">商品の情報</div>
            <div class="detail-content__section-group">
                <div class="detail-content__sub-section">カテゴリー</div>
                <div class="detail-content__category-group">
                    @foreach($item->categories as $category)
                        <div class="ditail-content__category">{{ $category->content }}</div>
                    @endforeach
                </div>
            </div>
            <div class="detail-content__section-group">
                <div class="detail-content__sub-section">商品の状態</div>
                <div class="detail-content__sub-section--text">{{ $item->condition->content }}</div>
            </div>

            <div class="detail-content__section--gray">{{ 'コメント(' . $comments->count() .')' }}</div>

            @foreach($comments as $comment)
                <div class="detail-content__user-group">
                    <div class="detail-content__user-icon"></div>
                    <div class="detail-content__user-name">{{ $comment->user->name }}</div>
                </div>
                <div class="detail-content__comment-area">
                    <p>{{ $comment->content }}</p>
                </div>
            @endforeach

            <form novalidate action="{{ '/item/' . $item->id . '/comment' }}" method="post">
                @csrf
                <div class="detail-content__sub-section">商品へのコメント</div>
                <textarea name="content" class="detail-content__textarea"></textarea>
                @error('content')
                    <div class="detail-content__error">{{ $message }}</div>
                @enderror
                <button type="submit" class="detail-content__button">コメントを送信する</button>
            </form>
        </div>
    </div>
    <div style="margin-bottom:178px;"></div>
@endsection