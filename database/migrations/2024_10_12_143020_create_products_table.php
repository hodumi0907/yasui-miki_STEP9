<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table -> id();
            $table -> integer('company_id'); //参照先のcompaniesテーブルとデータ型を合わせる
            $table -> string('product_name');
            $table -> integer('price'); //初期値：string
            $table -> integer('stock');
            $table -> text('comment') -> nullable();
            $table -> string('img_path') -> nullable();
            $table -> timestamps(); //'created_at'と'updated_at'をまとめてLaravelのデフォルトメソッドにかえる
            $table -> foreign('company_id') -> references('id') -> on('companies'); //外部キーの制約
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
