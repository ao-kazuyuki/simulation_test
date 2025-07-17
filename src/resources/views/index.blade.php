@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu', ['searchWord' => $searchWord ?? ''])
    @endcomponent
@endsection

@section('content')

<div class="item-menu">
    @isset($request)
        @if($request->page=='mylist')
            <a class="item-menu__link" href="/">おすすめ</a>
            <a class="item-menu__link--strong" href="{{ url('/?page=mylist') . '&keyword=' . urlencode($searchWord ?? '') }}">マイリスト</a>
        @endif
    @else
        <a class="item-menu__link--strong" href="/">おすすめ</a>
        <a class="item-menu__link" href="{{ url('/?page=mylist') . '&keyword=' . urlencode($searchWord ?? '') }}">マイリスト</a>
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