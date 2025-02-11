@extends('layouts.app')

@section('content')
<div class = "container">
    <h1 class = "mb-4">商品情報一覧</h1>

    @if (session('success')) <!-- 削除成功メッセージ -->
        <div class = "alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class = "search mt-5"> <!-- 検索フォーム -->
        <form action = "{{ route('products.index') }}" method = "GET" class = "row g-3">
            <div class = "col-sm-12 col-md-3"> <!-- 検索キーワード -->
                <input
                    type = "text"
                    name = "search"
                    class = "form-control" 
                    placeholder = "検索キーワード"
                    value = "{{ request('search') }}"
                >
            </div>

            <div class = "col-sm-12 col-md-3"> <!-- 企業名検索 -->
                <select name = "company_id" class = "form-control">
                    <option value = "">メーカー名</option>
                    @foreach ($companies as $company)
                    <option value = "{{ $company->id }}"
                        {{ request('company_id') == $company -> id ? 'selected' : '' }} >
                        {{ $company -> company_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class = "col-sm-12 col-md-1"> <!-- 検索ボタン -->
                <button class = "btn btn-outline-secondary" type = "submit">検索</button>
            </div>
        </form>
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th> <!-- 各項目 -->
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                    <th><a href = "{{ route('products.create') }}"class = "btn btn-primary mb-3">商品新規登録</a></th>
                </tr>
            </thead>

            <tbody> <!-- 商品情報 繰り返し表示 -->
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product -> company_id }}</td>
                        <td><img src = "{{ asset($product -> img_path) }}" alt = "画像なし" width = "100"></td>
                        <td>{{ $product -> product_name }}</td>
                        <td>{{ $product -> price }}</td>
                        <td>{{ $product -> stock }}</td>
                        <td>{{ $product -> company -> company_name }}</td>
                        <td>
                            <a href = "{{ route('products.show', $product) }}" 
                                class = "btn btn-info btn-sm mx-1">詳細</a>
                            <form
                                method="POST" 
                                action="{{ route('products.destroy', 
                                    ['product' => $product->id] + request()->query()) }}"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type = "submit"
                                    class = "btn btn-danger btn-sm mx-1"
                                    onclick = "return confirm('削除して問題ないですか？')">削除
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
</div>
@endsection
