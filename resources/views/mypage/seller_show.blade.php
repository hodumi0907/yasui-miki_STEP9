@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">出品商品詳細</h1>
    <div class="mb-3">
        <label class="form-label fw-bold">商品名:</label>
        <div>{{ $product->product_name }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">商品説明:</label>
        <div>{{ $product->description }}</div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">商品画像:</label>
        @if($product->img_path)
            <div>
                <img src="{{ $product->img_path }}" alt="商品画像" style="max-width: 300px;">
            </div>
        @else
            <div>画像なし</div>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">価格:</label>
        <div>¥{{ number_format($product->price) }}</div>
    </div>

    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
        onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">削除</button>
    </form>

    <a href="{{ route('mypage.user_index') }}" class="btn btn-secondary">戻る</a>
</div>
@endsection