@extends('layouts.app')

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')

<form novalidate action="{{ '/purchase/' . $item->id }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-menu" style="margin-top:59px;">
        <h1 class="form-menu__title" style="margin-top:0;margin-bottom:47px;">住所の変更</h1>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">郵便番号</h2>
                @error('post_code')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="post_code" type="text" value="{{ old('post_code', $request->post_code ?? $user->post_code ) }}">
        </div>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">住所</h2>
                @error('address')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="address" type="text" value="{{ old('address', $request->address ?? $user->address ) }}">
        </div>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">建物名</h2>
            </div>
            <input class="form-menu__input" style="margin-bottom:67px;" name="building" type="text"  value="{{ old('building', $request->building ?? $user->building ) }}">
        </div>
        <input type="hidden" name="paymentValue" value="{{ $request->payment }}">
        <input class="form-menu__button" style="margin-bottom:127px;" type="submit" value="更新する">
    </div>
</form>
@endsection