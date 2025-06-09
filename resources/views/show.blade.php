@extends('layouts.app')

@section('content')
<div class = "container">
    <h1 class = "mb-4">商品情報詳細</h1>

    <dl class = "row mt-3" >
        <dt class = "col-sm-3">商品番号</dt>
        <dd class = "col-sm-9">{{ $product -> id }}</dd>

        <dt class = "col-sm-3">商品名</dt>
        <dd class = "col-sm-9">{{$product -> product_name}}</dd>

        <dt class = "col-sm-3">メーカー</dt>
        <dd class = "col-sm-9">{{ $product->company->company_name }}</dd>

        <dt class = "col-sm-3">価格</dt>
        <dd class = "col-sm-9">{{ $product -> price }}</dd>

        <dt class="col-sm-3">在庫数</dt>
        <dd class="col-sm-9">{{ $product -> stock }}</dd>

        <dt class="col-sm-3">商品説明</dt>
        <dd class="col-sm-9">{{ $product -> description }}</dd>

        <dt class="col-sm-3">商品画像</dt>
        <dd class="col-sm-9"><img src="{{ asset($product -> img_path) }}" width="300"></dd>
    </dl>

    <a href = "{{ route('products.edit', $product) }}" class = "btn btn-primary btn-sm mx-3">編集</a>
    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            class="btn btn-danger btn-sm mx-1"
            onclick="return confirm('削除して問題ないですか？')"
        >
            削除
        </button>
    </form>
    <!-- search & company_id のパラメータを維持して一覧画面に戻る⇒indexで検索結果を保持したまま表示 -->
    <a
        href="{{ route('products.index', ['search' => request('search'), 'company_id' => request('company_id')]) }}"
        class="btn btn-primary mt-3"
    >商品一覧画面に戻る</a>
</div>
@endsection
