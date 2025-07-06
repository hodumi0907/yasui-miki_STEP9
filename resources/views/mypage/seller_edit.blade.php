@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">出品商品編集</h1>
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_name" class="form-label">商品名:</label>
            <input
                id="product_name"
                type="text"
                name="product_name"
                value="{{ old('product_name', $product->product_name) }}"
                class="form-control @error('product_name') is-invalid @enderror"
            >
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格:</label>
            <input
                id="price"
                type="number"
                name="price"
                value="{{ old('price', $product->price) }}"
                class="form-control @error('price') is-invalid @enderror"
            >
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">商品説明:</label>
            <textarea
                id="description"
                name="description"
                rows="3"
                class="form-control @error('description') is-invalid @enderror"
            >{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数:</label>
            <input
                id="stock"
                type="number"
                name="stock"
                value="{{ old('stock', $product->stock) }}"
                class="form-control @error('stock') is-invalid @enderror"
            >
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="img_path" class="form-label">商品画像:</label>
            @if($product->img_path)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" style="max-width: 200px;">
                </div>
            @endif
            <input
                id="img_path"
                type="file"
                name="img_path"
                class="form-control @error('img_path') is-invalid @enderror"
                accept="image/jpeg,image/png,image/gif"
            >
            @error('img_path')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('mypage.user_index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection