@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="col-auto">アカウント情報編集</h1>

    <form method="POST" action="{{ route('user.update') }}">
        @csrf
        @method('PUT')

        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <label for="name" class="form-label">ユーザー名：</label>
            </div>
            <div class="col-auto">
                <input
                    id="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    autocomplete="name"
                    autofocus
                    placeholder="ユーザー名"
                >
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <label for="name_kanji" class="form-label">名前（漢字）：</label>
            </div>
            <div class="col-auto">
                <input
                    id="name_kanji"
                    type="text"
                    class="form-control @error('name_kanji') is-invalid @enderror"
                    name="name_kanji"
                    value="{{ old('name_kanji', $user->name_kanji) }}"
                    required
                    placeholder="名前（漢字）"
                >
                @error('name_kanji')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <label for="name_kana" class="form-label">名前（カナ）：</label>
            </div>
            <div class="col-auto">
                <input
                    id="name_kana"
                    type="text"
                    class="form-control @error('name_kana') is-invalid @enderror"
                    name="name_kana"
                    value="{{ old('name_kana', $user->name_kana) }}"
                    placeholder="名前（カナ）"
                >
                @error('name_kana')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <label for="email" class="form-label">アドレス：</label>
            </div>
            <div class="col-auto">
                <input
                    id="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="email"
                    placeholder="アドレス"
                >
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <label for="password" class="form-label">パスワード：</label>
            </div>
            <div class="col-auto">
                <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    autocomplete="new-password"
                    placeholder="変更する場合のみ入力"
                >
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <label for="password" class="form-label">パスワード（確認用）：</label>
            </div>
            <div class="col-auto">
                <input
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    autocomplete="new-password"
                    placeholder="変更する場合のみ入力"
                >
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-auto">
                <button type="submit" class="btn btn-warning">更新</button>
                <a href="{{ route('mypage.user_index') }}" class="btn btn-primary">戻る</a>
            </div>
        </div>
    </form>
</div>
@endsection
