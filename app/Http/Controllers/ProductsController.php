<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
    public function create(Request $request)
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
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try{
            //新しく商品データを作るための情報をリクエストから取得。
            $product = new Product([
                'product_name' => $request -> get('product_name'), // 商品名
                'company_id' => $request -> get('company_id'), // 会社ID
                'price' => $request -> get('price'), // 価格
                'stock' => $request -> get('stock'), // 在庫数
                'comment' => $request -> get('comment'), // コメント
            ]);
            //ファイルがアップロードされていればそのパスを保存
            if ($request -> hasFile('img_path')) {
                $imageInfo = getimagesize($request -> file('img_path'));
                // MIME タイプを取得
                $mimeType = $imageInfo['mime'];
                // 必要に応じてMIMEタイプをチェック（例:jpeg画像かどうか）
                if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                    return back() -> with('error', '無効な画像形式です。');
                }

                // アップロードされた画像を 'products' フォルダに保存
                $filePath = $request -> file('img_path') -> store('products', 'public');
                // 保存したファイルパスを商品情報にセット
                $product -> img_path = '/storage/' . $filePath;
            }

            //　商品情報をデータベースに保存
            $product -> save();
            // すべてが成功したらトランザクションをコミット
            DB::commit();

            // 商品登録が完了したメッセージと共に新規登録画面にリダイレクト
            return redirect()
                -> route('products.create', $product)
                -> with('success', '商品登録が完了しました');
            } catch (\Exception $e) {
                // 例外が発生した場合はロールバック
                DB::rollBack();
                return back() -> with('error', '商品登録が出来ませんでした:' . $e -> getMessage());
            }
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
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {           
            $product -> product_name = $request -> product_name; //入力された商品名をプロパティに代入
            $product -> price = $request -> price; //価格
            $product -> stock = $request -> stock; //在庫数
            $product -> comment = $request -> comment; // コメント

            if ($request -> hasFile('img_path')) { //更新内容に画像ファイルが含まれていたときの処理
                // すでに画像が保存されている場合、古い画像を削除する
                if ($product -> img_path) {
                    // 古い画像のパスから '/storage/' を取り除き、ストレージから削除
                    Storage::disk('public') -> delete(str_replace('/storage/', '', $product -> img_path));
                }
                $filePath = $request -> file('img_path') -> store('products', 'public');// 新しい画像ファイルを 'products' フォルダに保存
                $product -> img_path = '/storage/' . $filePath; // 保存された新しい画像のパスをデータベースに保存
            }

            $product -> save();
            DB::commit();

            return redirect() // 全ての処理終了後のリダイレクト先
                -> route('products.show', [ //商品編集ページにリダイレクト
                    'product' => $product -> id,
                    'search' => $request -> query('search'), // 検索条件を渡す
                    'company_id' => $request -> query('company_id'),
            ])
                -> with('success', '更新完了');//送信成功したときのメッセージ
        } catch (\Exception $e) {
            DB::rollBack();
            // エラーメッセージをセッションに保存し、リダイレクト
            return back() -> with('error', '更新出来ませんでした：' . $e -> getMessage());
        }
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
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id); // 該当する商品IDをもとに、データベースから商品を検索
            // 商品に画像が設定されている場合、その画像ファイルを削除
            if ($product -> img_path) {
                // ストレージから画像を削除（publicディスクの中から）
                Storage::disk('public') -> delete(str_replace('/storage/', '', $product->img_path));
            }
            $product -> delete(); // データベースから商品情報を削除
            DB::commit(); // すべての処理が正常に完了した場合、トランザクションをコミット
            // 商品一覧ページにリダイレクトし、削除成功メッセージを表示
            return redirect()
                -> route('products.index', [
                    'search' => $request -> query('search'), //現在のキーワードを取得
                    'company_id' => $request -> query('company_id')//現在のメーカー名を取得
                ])
                -> with('success', '商品を削除しました。');//削除成功のメッセージを記載
            } catch (\Exception $e) {
                // 何かエラーが発生した場合、トランザクションをロールバックして変更をキャンセル
                DB::rollBack();
                return back() -> with('error', '削除が出来ませんでした' . $e -> getMessage());
        }
    }
}
