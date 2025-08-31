@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報詳細</h1>

    <dl class="row mt-3" >
        <dt class="col-sm-3">商品名</dt>
        <dd class="col-sm-9">{{$product -> product_name}}</dd>

        <dt class="col-sm-3">商品説明</dt>
        <dd class="col-sm-9">{{ $product -> description }}</dd>

        <dt class="col-sm-3">商品画像</dt>
        <dd class="col-sm-9"><img src="{{ asset($product -> img_path) }}" width="300"></dd>

        <dt class="col-sm-3">価格</dt>
        <dd class="col-sm-9">{{ $product -> price }}</dd>

        <dt class="col-sm-3">メーカー</dt>
        <dd class="col-sm-9">{{ $product->company->company_name }}</dd>
    </dl>

    <!-- お気に入りボタン -->
    <button id="favorite-btn" class="btn btn-outline-danger me-3" type="button" aria-label="お気に入り登録">
        <i class="fa-regular fa-heart"></i>
    </button>

    <a href="{{ route('purchase.form', $product) }}" class="btn btn-success mx-3">カートに追加</a>
    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">商品一覧画面に戻る</a>
</div>
@endsection
