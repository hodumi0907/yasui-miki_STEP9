@extends('layouts.app')

@section('content')
<div class="container"> <!--ログインフォーム真ん中-->
    <div class = "row justify-content-center">
        <div class = "col-md-8">
            <div class = "card"> <!--ログインフォームをカードデザインで表示する-->
                <div class = "card-header text-center">{{ __('ユーザーログイン画面') }}</div> <!--カードのヘッダー部分/タイトル-->

                <div class="card-body">
                    <form method = "POST" action = "{{ route('login') }}"> <!--POSTメソッドでデータを送信-->
                        <!--{{ route('login') }}は、ログイン処理を行うルート（URL）-->
                        @csrf

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
                                        autofocus placeholder = "アドレス"
                                    >

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
                                        required autocomplete = "current-password"
                                        placeholder = "パスワード"
                                    >

                                    @error('password')
                                    <span class = "invalid-feedback" role = "alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3"> <!--ログイン状態を保持するチェックボックス-->
                            <div class="col-md-6 offset-md-3">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label
                                        class="form-check-label" for="remember">
                                            {{ __('ログイン状態を保持する') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class = "row mb-0"> <!--ボタンを横並びに配置-->
                            <div class = "col-md-4 offset-md-4 text-center">
                                
                                <a href = "{{ route('register') }}" class = "btn btn-warning"> <!--新規登録ボタン-->
                                    {{ __('新規登録') }}
                                </a>

                                <button type = "submit" class = "btn btn-primary">
                                    {{ __('ログイン') }}
                                </button>
                        <!--ここにあったパスワードを忘れた場合の請求リンク（Forgot Your Password?）は削除-->
                        <!--基本削除しない-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
