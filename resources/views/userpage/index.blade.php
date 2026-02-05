@extends('layouts.app')

@section('content')
<div class = "container">
    <h1 class = "mb-4">商品情報一覧</h1>
    
    <div class = "search mt-5"> <!-- 検索フォーム -->
        <form action = "{{ route('products.index') }}" method = "GET" class = "row g-3">
            <div class = "col-sm-12 col-md-3"> <!-- 商品名検索 -->
                <input
                    type = "text"
                    name = "search"
                    class = "form-control" 
                    placeholder = "商品名"
                    value = "{{ request('search') }}"
                >
            </div>

            <div class = "col-sm-12 col-md-2"> <!-- 価格の最小値 -->
                <input
                    type = "number"
                    name = "price_min"
                    class = "form-control"
                    placeholder = "最低価格"
                    value = "{{ request('price_min') }}"
                >
            </div>

            <div class = "col-sm-12 col-md-2"> <!-- 価格の最大値 -->
                <input
                    type = "number"
                    name = "price_max"
                    class = "form-control"
                    placeholder = "最高価格"
                    value = "{{ request('price_max') }}"
                >
            </div>

            <div class = "col-sm-12 col-md-1"> <!-- 検索ボタン -->
                <button class = "btn btn-outline-secondary" type = "submit">検索</button>
            </div>
        </form>
    
        <table class="table table-striped">
            <thead> <!-- 各項目 -->
                <tr>
                    <th>商品番号</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>商品説明</th>
                    <th>価格</th>
                </tr>
            </thead>

            <tbody> <!-- 商品情報 繰り返し表示 -->
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product -> id }}</td>
                        <td><img src = "{{ asset($product -> img_path) }}" alt = "画像なし" width = "100"></td>
                        <td>{{ $product -> product_name }}</td>
                        <td>{{ $product -> description }}</td>
                        <td>{{ $product -> price }}</td>
                        <td>
                            <a href="{{ route('products.detail', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
</div>
@endsection
