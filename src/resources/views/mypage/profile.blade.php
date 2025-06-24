@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')

<form novalidate action="/mypage/profile/update" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <div class="form-menu" style="margin-top:59px;">
        <input type="hidden" name="id" value="{{ $user->id }}">
        <input type="hidden" name="img_src" id="img_src" value="">
        <h1 class="form-menu__title" style="margin-top:0;margin-bottom:47px;">プロフィール設定</h1>
        <div class="profile-content__input-image">
            <!-- TODO:バリデーション時の画像の保持 -->
            <div class="profile-content__input-image--circle" id="preview"></div>
            <div class="profile-content__input-image--group">
                <button class="profile-content__input-image--button" id="uploadBotton">画像を選択する</button>
                <input type="file" name="img_file" id="fileInput" accept="image/*" style="display: none;">
                @error('img_file')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <script>
                const uploadBotton = document.getElementById('uploadBotton');
                const fileInput = document.getElementById('fileInput');
                const preview = document.getElementById('preview');
                let removeElm = null;
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
                        if(removeElm!=null){
                            preview.removeChild(removeElm);
                        }
                        removeElm = img;
                        preview.appendChild(img);
                        const hiddenElm = document.getElementById('img_src');
                        hiddenElm.value = file.name;
                    };
                    reader.readAsDataURL(file);     //todo:要検討
                });
            </script>
        </div>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">ユーザー名</h2>
                @error('name')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="name" type="text" value="{{ old('name', $user->name ?? '' ) }}">
        </div>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">郵便番号</h2>
                @error('post_code')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="post_code" type="text" value="{{ old('post_code', $user->post_code ?? '' ) }}">
        </div>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">住所</h2>
                @error('address')
                    <span class="form-menu__error">{{ $message }}</span>
                @enderror
            </div>
            <input class="form-menu__input" name="address" type="text" value="{{ old('address', $user->address ?? '' ) }}">
        </div>
        <div class="form-menu__group">
            <div class="form-menu__section-group">
                <h2 class="form-menu__section">建物名</h2>
            </div>
            <input class="form-menu__input" style="margin-bottom:67px;" name="building" type="text"  value="{{ old('building', $user->building ?? '' ) }}">
        </div>
        <input class="form-menu__button" style="margin-bottom:127px;" type="submit" value="更新する">
    </div>
</form>
@endsection