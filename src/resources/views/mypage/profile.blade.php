@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')
<form class="profile-form" action="/mypage/profile/update" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="img_src" id="img_src" value="">    <!-- 投稿画像のファイル名 -->
    <h1 class="profile-form__title">プロフィール設定</h1>
    <!-- プロフィール画像 -->
    <div class="profile-image__group">
        <div class="profile-image__circle" id="preview"></div>
        <div class="profile-image__select--group">
            <button class="profile-image__button" id="uploadBotton">画像を選択する</button>
            <input type="file" name="img_file" id="fileInput" accept="image/*" style="display:none;">
            <div class="form-error" style="margin-bottom:0;">
                @error('img_file')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <!-- ローカルの画像をアップロードしてdiv要素へ貼付 -->
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
                reader.readAsDataURL(file);
            });
        </script>
    </div>
    <!-- ユーザー名 -->
    <div>
        <h2 class="profile-section">ユーザー名</h2>
        <input class="profile-input" name="name" type="text" value="{{ old('name', $user->name ?? '' ) }}">
        <div class="form-error">
            @error('name')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- 郵便番号 -->
    <div>
        <h2 class="profile-section">郵便番号</h2>
        <input class="profile-input" name="post_code" type="text" value="{{ old('post_code', $user->post_code ?? '' ) }}">
        <div class="form-error">
            @error('post_code')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- 住所 -->
    <div>
        <h2 class="profile-section">住所</h2>
        <input class="profile-input" name="address" type="text" value="{{ old('address', $user->address ?? '' ) }}">
        <div class="form-error">
            @error('address')
                {{ $message }}
            @enderror
        </div>
    </div>
    <!-- 建物名 -->
    <div>
        <h2 class="profile-section">建物名</h2>
        <input class="profile-input" name="building" type="text"  value="{{ old('building', $user->building ?? '' ) }}">
    </div>
    <!-- 更新ボタン -->
    <input class="profile__button" type="submit" value="更新する">
</form>
@endsection