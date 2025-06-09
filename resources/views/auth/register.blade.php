@extends('layouts.app')

@section('content')
<div class = "container">
    <div class = "row justify-content-center">
        <div class = "col-md-8">
            <div class = "card">
                <div class = "card-header text-center">{{ __('ユーザー新規登録画面') }}</div>

                <div class = "card-body">
                    <form method = "POST" action = "{{ route('register') }}">
                        @csrf

                        <div class = "row mb-3"> <!--ユーザー名入力フィールド-->
                            <div class = "row justify-content-center">
                                <div class = "col-md-6">
                                    <input
                                        id = "name"
                                        type = "text"
                                        class = "form-control @error('name') is-invalid @enderror"
                                        name = "name"
                                        value = "{{ old('name') }}"
                                        required
                                        autocomplete = "name"
                                        autofocus
                                        placeholder = "ユーザー名"
                                    > <!-- input終了 -->
                                    @error('name')
                                        <span class = "invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3"> <!-- 名前（漢字）入力フィールド -->
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <input
                                        id="name_kanji"
                                        type="text"
                                        class="form-control @error('name_kanji') is-invalid @enderror"
                                        name="name_kanji"
                                        value="{{ old('name_kanji') }}"
                                        required
                                        placeholder="名前（漢字）"
                                    > <!-- input終了 -->
                                    @error('name_kanji')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3"> <!-- 名前（カナ）入力フィールド -->
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <input
                                        id="name_kana"
                                        type="text"
                                        class="form-control @error('name_kana') is-invalid @enderror"
                                        name="name_kana"
                                        value="{{ old('name_kana') }}"
                                        placeholder="名前（カナ）"
                                    > <!-- input終了 -->
                                    @error('name_kana')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class = "row mb-3"> <!--メールアドレス入力フィールド-->
                            <div class = "row justify-content-center">
                                <div class = "col-md-6">
                                    <input
                                        id = "email"
                                        type = "email"
                                        class = "form-control @error('email') is-invalid @enderror"
                                        name = "email"
                                        value = "{{ old('email') }}"
                                        required autocomplete = "email"
                                        placeholder = "アドレス"
                                    > <!-- input終了 -->
                                    @error('email')
                                        <span class = "invalid-feedback" role = "alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class = "row mb-3"> <!--パスワード入力フィールド-->
                            <div class = "row justify-content-center">
                                <div class = "col-md-6">
                                    <input
                                        id = "password"
                                        type = "password"
                                        class = "form-control @error('password') is-invalid @enderror"
                                        name = "password"
                                        required autocomplete = "new-password"
                                        placeholder = "パスワード"
                                    > <!-- input終了 -->
                                    @error('password')
                                        <span class = "invalid-feedback" role = "alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class = "row mb-3"> <!--パスワード確認入力フィールド-->
                            <div class = "row justify-content-center">
                                <div class = "col-md-6">
                                    <input
                                        id = "password-confirm"
                                        type = "password"
                                        class = "form-control"
                                        name = "password_confirmation"
                                        required autocomplete = "new-password"
                                        placeholder = "パスワード（確認用）"
                                    > <!-- input終了 -->
                                </div>
                            </div>
                        </div>

                        <div class = "row mb-0"> <!--ボタンを横並びに配置-->
                            <div class = "col-md-4 offset-md-4 text-center">

                                <button type = "submit" class="btn btn-warning">
                                    {{ __('新規登録') }}
                                </button>

                                <a href = "{{ route('login') }}" class = "btn btn-primary">
                                    {{ __('戻る') }}
                                </a>    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
