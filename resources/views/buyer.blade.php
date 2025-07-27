@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">購入</h1>

    <dl class = "row mt-3" >
        <dt class = "col-sm-3">商品名</dt>
        <dd class = "col-sm-9">{{$product -> product_name}}</dd>

        <dt class="col-sm-3">商品説明</dt>
        <dd class="col-sm-9">{{ $product -> description }}</dd>

        <dt class="col-sm-3">商品画像</dt>
        <dd class="col-sm-9"><img src="{{ asset($product -> img_path) }}" width="300"></dd>

        <dt class = "col-sm-3">価格</dt>
        <dd class = "col-sm-9">{{ $product -> price }}</dd>

        <dt class="col-sm-3">在庫数</dt>
        <dd class="col-sm-9">{{ $product -> stock }}</dd>

        <dt class = "col-sm-3">メーカー</dt>
        <dd class = "col-sm-9">{{ $product->company->company_name }}</dd>

        <dt class = "col-sm-3">購入数</dt>
        <dd class="col-sm-9">
            <form method="POST" action="{{ route('purchase.process', ['product' => $product->id]) }}" id="purchase-form">
                @csrf
                <input
                    type="number"
                    name="purchase_quantity"
                    value="1"
                    min="1"
                    max="{{ $product->stock }}"
                    required
                    class="form-control w-25"
                    id="purchase_quantity"
                    form="purchase-form"
                >
                <button type="submit" class="btn btn-primary mt-3">購入</button>
            </form>
        </dd>
    </dl>
    <a
        href="{{ route('products.index', ['search' => request('search'), 'company_id' => request('company_id')]) }}"
        class="btn btn-primary mt-3">商品一覧画面に戻る
    </a>
</div>
@endsection