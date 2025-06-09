<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 1.バリデーション
        // price_min と price_max の値が数値（numeric）かつ0以上（min:0）であるかをチェック
        $request->validate([
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
        ]);

        // 2.クエリビルダを作成（Productモデルをもとにデータベースから検索する準備）
        $query = Product::query();

        // 3.「検索キーワード」が送られてきている場合（空文字でない場合）
        if ($request -> has('search') && $request -> search != '') {
            $query -> where('product_name', 'like', '%' . $request->search . '%');
        }

        // 4.「価格の下限」が送られてきている場合
        if ($request->price_min !== null) {
            // price が指定した下限以上のデータを絞り込む
            $query->where('price', '>=', $request->price_min);
        }

        // 5.「価格の上限」が送られてきている場合
        if ($request->price_max !== null) {
            // price が指定した上限以下のデータを絞り込む
            $query->where('price', '<=', $request->price_max);
        }

        // 6.ログインユーザー以外の商品だけ表示
        $query->where('user_id', '!=', Auth::id());

        // 7.商品番号で昇順に並び替え、結果を取得する
        $products = $query->orderBy('company_id', 'asc')->get();

        // 8.ビュー（index）に取得したデータを渡して表示する
        return view('index', compact('products'));
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
                'description' => $request -> get('description'), // 商品説明
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

            // 商品情報をデータベースに保存しコミット
            $product -> save();
            DB::commit();

            // 商品登録が完了時のメッセージ、リダイレクト先、例外時のエラー
            return redirect()
                -> route('mypage.index', $product)
                -> with('success', '商品登録が完了しました');
            } catch (\Exception $e) {
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
            $product -> company_id = $request -> company_id; //会社ID
            $product -> price = $request -> price; //価格
            $product -> stock = $request -> stock; //在庫数
            $product -> description = $request -> description; // コメント

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
