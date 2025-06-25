@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')

<form novalidate action="/sell" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-menu" style="margin-top:51px;">
        <input type="hidden" name="id" value="{{ $user->id }}">
        <input type="hidden" name="img_src" id="img_src" value="">
        <h1 class="form-menu__title" style="margin-top:0;margin-bottom:43px;">商品の出品</h1>
        <div class="sell-content__image-group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">商品画像</h2>
                @error('img_file')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="sell-content__image-area" id="preview">
                <button class="sell-content__input-image--button" id="uploadBotton">画像を選択する</button>
                <input type="file" name="img_file" id="fileInput" accept="image/*" style="display: none;">
                <script>
                    const uploadBotton = document.getElementById('uploadBotton');
                    const fileInput = document.getElementById('fileInput');
                    const preview = document.getElementById('preview');
                    uploadBotton.addEventListener('click', () => {
                        event.preventDefault();
                        fileInput.click();
                    });
                    fileInput.addEventListener('change', () => {
                        const file = fileInput.files[0];
                        if (!file) return;
                        const reader = new FileReader();
                        reader.onload = () => {
                            const img = document.createElement('img');
                            img.src = reader.result;
                            preview.style.alignItems = "normal";
                            preview.removeChild(uploadBotton);
                            preview.appendChild(img);
                            const hiddenElm = document.getElementById('img_src');
                            hiddenElm.value = file.name;
                        };
                        reader.readAsDataURL(file);     //todo:要検討
                    });
                </script>
            </div>
        </div>

        <h2 class="sell-content__sub-section" style="margin-top:0">商品の詳細</h2>
        <div class="sell-content__category-group">

            <div class="form-menu__section-group">
                <h2 class="form-menu__section" style="margin-bottom:15px;">カテゴリー</h2>
                @error('category_group')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="sell-content__categories">
            @foreach($categories as $category)
                <label>
                    <input type="checkbox" name="category_group[]" value="{{ $category->id }}" {{ in_array( $category->id, old('category_group', [])) ? 'checked' : '' }} class="sell-content__category">
                    <span class="sell-content__category-label">{{ $category->content }}</span>
                </label>
            @endforeach
            </div>

            <div class="form-menu__section-group">
                <h2 class="form-menu__section">商品の状態</h2>
                @error('condition')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <select class="sell-content__selecter" name="condition">
                <option value="" selected>選択してください</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition') == $condition->id ? 'selected' : '' }} >{{ $condition->content }}</option>
                @endforeach
            </select>
        </div>

        <h2 class="sell-content__sub-section">商品名と説明</h2>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">商品名</h2>
                @error('name')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="name" type="text" value="{{ old('name') }}">
        </div>

        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">ブランド名</h2>
            </div>
            <input class="form-menu__input" name="brand" type="text" value="{{ old('brand') }}">
        </div>

        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">商品の説明</h2>
                @error('explanation')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <textarea class="sell-content__textarea" name="explanation">{{ old('explanation') }}</textarea>
        </div>

        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">販売価格</h2>
                @error('price')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" style="margin-bottom:118px;" name="price" type="text" placeholder="￥" value="{{ old('price') }}">
        </div>

        <input class="form-menu__button" style="margin-bottom:152px;" type="submit" value="出品する">
    </div>
</form>
@endsection