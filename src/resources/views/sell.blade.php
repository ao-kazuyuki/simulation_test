@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')
<form class="sell-form" action="/sell" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="img_src" id="img_src" value="">
    <h1 class="sell-form__title">商品の出品</h1>
    <!-- 商品画像 -->
    <div class="sell-item__img-group">
        <h3 class="sell-section">商品画像</h3>
        <div class="sell-item__prev" id="preview">
            <button class="sell-item__button" id="uploadBotton">画像を選択する</button>
            <input type="file" name="img_file" id="fileInput" accept="image/*" style="display:none;">
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
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.onload = () =>{
                            const ratio = img.height / img.width;
                            const targetWidth = 300;
                            const targetHeight = targetWidth * ratio;
                            img.width = targetWidth;
                            img.height = targetHeight;
                            preview.style.alignItems = "normal";
                            preview.style.height = targetHeight + "px";
                            if(preview.contains(uploadBotton)){
                                preview.removeChild(uploadBotton);
                            }
                            preview.appendChild(img);
                            const hiddenElm = document.getElementById('img_src');
                            if(hiddenElm){
                                hiddenElm.value = file.name;
                            }
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            </script>
        </div>
        <div class="form-error" style="margin-bottom:46px;">
            @error('img_file')
                {{ $message }}
            @enderror
        </div>
    </div>
    <h2 class="sell-section__gray">商品の詳細</h2>
    <!-- カテゴリー -->
    <h3 class="sell-section section-margin">カテゴリー</h3>
    <div class="sell-categories">
        @foreach($categories as $category)
            <label>
                <input class="sell-category" type="checkbox" name="category_group[]" value="{{ $category->id }}" {{ in_array( $category->id, old('category_group', [])) ? 'checked' : '' }}>
                <span class="sell-category__label">{{ $category->content }}</span>
            </label>
        @endforeach
    </div>
    <div class="form-error" style="margin-bottom:40px;">
        @error('category_group')
            {{ $message }}
        @enderror
    </div>
    <!-- 商品の状態 -->
    <h3 class="sell-section">商品の状態</h3>
    <div class="sell-condition__selecter">
        <select name="condition">
            <option value="" selected hidden>選択してください</option>
            @foreach($conditions as $condition)
                <option class="sell-condition__drop" value="{{ $condition->id }}" {{ old('condition') == $condition->id ? 'selected' : '' }} >
                    {{ $condition->content }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-error" style="margin-bottom:46px;">
        @error('condition')
            {{ $message }}
        @enderror
    </div>
    <h2 class="sell-section__gray">商品名と説明</h2>
    <!-- 商品名 -->
    <h3 class="sell-section">商品名</h3>
    <input class="sell-input" name="name" type="text" value="{{ old('name') }}">
    <div class="form-error" style="margin-bottom:24px;">
        @error('name')
            {{ $message }}
        @enderror
    </div>
    <!-- ブランド名 -->
    <h3 class="sell-section">ブランド名</h3>
    <input class="sell-input bottom-margin" name="brand" type="text" value="{{ old('brand') }}">
    <!-- 商品の説明 -->
    <h3 class="sell-section">商品の説明</h3>
    <textarea class="sell-textarea" name="explanation">{{ old('explanation') }}</textarea>
    <div class="form-error" style="margin-bottom:12px;">
        @error('explanation')
            {{ $message }}
        @enderror
    </div>
    <!-- 販売価格 -->
    <h3 class="sell-section">販売価格</h3>
    <input class="sell-input" name="price" type="text" placeholder="￥" value="{{ old('price') }}">
    <div class="form-error">
        @error('price')
            {{ $message }}
        @enderror
    </div>
    <!-- 出品ボタン -->
    <input class="sell__button" type="submit" value="出品する">
</form>
@endsection