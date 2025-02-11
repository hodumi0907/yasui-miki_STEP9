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
        Schema::create('sales', function (Blueprint $table) {
            $table -> id();
            $table -> integer('product_id');//参照先のproductテーブルとデータ型を合わせる
            $table -> timestamps(); //'created_at'と'updated_at'をまとめてLaravelのデフォルトメソッドにかえる
            $table -> foreign('product_id') -> references('id') -> on('products'); //外部キーの制約
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
