<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 初期化: Productモデルのクエリビルダーを取得
        // クエリビルダーを使って動的にデータベースに対する条件を追加していく
        $query = Product::query();

        // 検索パラメータ（search）がリクエストに含まれている場合
        // 'product_name'（商品名）が検索ワードで部分一致する商品を絞り込む
        if ($request -> has('search') && $request -> search != '') {
           // 商品名が部分一致するものを取得
            $query -> where('product_name', 'like', '%' . $request->search . '%');
        }

        // 企業名（company_id）がリクエストに含まれている場合
        // もし企業IDが指定されているなら、その企業に関連する商品を絞り込む
        if ($request -> has('company_id') && $request -> company_id != '') {
            // 企業IDで絞り込む
            $query -> where('company_id', $request -> company_id);
        }

        // クエリに基づいて商品データを取得（検索条件があれば絞り込む）
        // 絞り込まれた結果を$productsに格納
        $products = $query -> get();

        // 企業のリストを取得（メーカー名検索のため）
        // 企業の選択肢を取得するため、Companyモデルから全ての企業を取得
        $companies = Company::all();

        // 'index'ビューにデータを渡して表示
        return view('index', compact('products', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Companyのデータベースから全ての会社情報を取得する
        $companies = Company::all();
        //'product.create'ビューにデータを渡して表示する
        return view('create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ // '|'はバリデーションルールを複数指定
            'product_name' => 'required', //required＝必須
            'company_id' => 'required',
            'price' => 'required | integer | min:0', //必須、整数のみ（-1、0.1不可）、0でも可
            'stock' => 'required | integer | min:0',
            'comment' => 'nullable', //nullableは未入力でOKという意味
            'img_path' => 'nullable | image',
        ]);

        //新しく商品データを作る。そのための情報をリクエストから取得。
        //newを使うと新しいインスタンスを作成できる
        $product = new Product([
            'product_name' => $request -> get('product_name'),
            'company_id' => $request -> get('company_id'),
            'price' => $request -> get('price'),
            'stock' => $request -> get('stock'),
            'comment' => $request -> get('comment'),
        ]);

        if ($request -> hasFile('img_path')){ //ファイルがアップロードされていればtrueを返す 
            $filename = $request -> img_path -> getClientOriginalName(); //アップロードされたファイル名を取得する
            //指定のディレクトリに保存する（保存先,ファイル名,保存先のストレージドライバ/storage/app/public）
            $filePath = $request -> img_path -> storeAs('products', $filename, 'public');
            //保存したファイルの公開URLをDBに保存する。'/storage/'は公開ディレクトリ（public/storage）
            $product -> img_path = '/storage/' . $filePath;
        }

        //データベースに新しい商品として保存する
        $product -> save();
        //全ての処理が終わったら商品一覧画面に戻る
        return redirect()
            -> route('products.create', $product)
            -> with('success', '商品登録が完了しました');//送信成功したときのメッセージ
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //resources/views/products/show.blade.phpを表示する
        //商品詳細でsearch と company_idを受け取る
        $product = Product::with('company') -> findOrFail($id);
        return view('show', compact('product')) -> with([
            'search' => $request -> query('search'),
            'company_id' => $request -> query('company_id')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) //自動的にデータベースから該当するレコードを取得し$productに代入
    {
        //Companyのデータベースから全ての会社情報を取得する
        $companies = Company::all();
        //view('products.edit' ＝ 商品編集画面（resources/views/products/edit.blade.php）を表示
        //compact('product', 'companies') ＝ 編集対象の商品データと会社情報を画面に渡す
        return view('edit', compact('product', 'companies'));
        //流れ：ユーザーがアクセスするとControllerのedit()メソッドを呼び出し
        //→自動的にDBから該当するレコードを取得、$productへ該当データを代入→DBから企業リストを取得
        //→ビュー（products.edit）を表示、$productと$companiesデータを渡す
        //編集後に更新ボタンを押すと次のアクションに処理が渡る
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //$request＝フォームから送信されたデータを保持
    //自動的にデータベースから該当するレコードを取得し$productに代入
    public function update(Request $request, Product $product)
    {
        //入力されたデータを確認し必要な情報が全て揃っているかチェック。
        $request -> validate([
            'product_name' => 'required',//'required'＝入力必須
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product -> product_name = $request -> product_name; //入力された商品名をプロパティに代入
        $product -> price = $request -> price; //価格
        $product -> stock = $request -> stock; //在庫数
        $product -> save(); //データベースに更新（入力）内容を保存

        // 全ての処理終了後のリダイレクト先
        return redirect()
            -> route('products.show', [ //商品編集ページにリダイレクト
                'product' => $product -> id,
                'search' => $request -> query('search'), // 検索条件を渡す
                'company_id' => $request -> query('company_id'),
            ])
            -> with('success', '更新完了');//送信成功したときのメッセージ
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //指定された商品データを削除する
    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product -> delete();//該当する商品をデータベースから削除
        return redirect()
            -> route('products.index', [ //商品一覧ページへリダイレクト
                'search' => $request -> query('search'), //現在のキーワードを取得
                'company_id' => $request -> query('company_id')//現在のメーカー名を取得
            ])
            -> with('success', '商品を削除しました。');//削除成功のメッセージを記載
    }
}
