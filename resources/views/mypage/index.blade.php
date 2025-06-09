@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">マイページ</h1>
<!-- アカウント編集ボタン -->
    <a href="{{ route('user.edit') }}" class="btn btn-primary mb-3">アカウント情報を編集</a>

<!-- ログイン中のユーザー情報 -->
    <dl class="row">
        <dt class="col-sm-3">ユーザー名</dt>
        <dd class="col-sm-9">{{ Auth::user()->name }}</dd>

        <dt class="col-sm-3">メールアドレス</dt>
        <dd class="col-sm-9">{{ Auth::user()->email }}</dd>

        <dt class="col-sm-3">名前（漢字）</dt>
        <dd class="col-sm-9">{{ Auth::user()->name_kanji }}</dd>

        <dt class="col-sm-3">名前（カナ）</dt>
        <dd class="col-sm-9">{{ Auth::user()->name_kana }}</dd>
    </dl>

<!-- 出品商品 -->
    <h2 class="mt-5">【出品商品】</h2>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">新規商品登録</a>
    @if($myProducts->isEmpty())
        <p>登録された商品はありません。</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>商品番号</th>
                    <th>商品名</th>
                    <th>商品説明</th>
                    <th>金額</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myProducts as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td><a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">詳細</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- 購入した商品 -->
    <!--
    <h2 class="mt-5">【購入した商品】</h2>
    @if($purchasedProducts->isEmpty())
        <p>購入した商品はありません。</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>商品説明</th>
                    <th>金額</th>
                    <th>個数</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchasedProducts as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->product->description }}</td>
                    <td>{{ $item->product->price }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    -->
</div>
@endsection