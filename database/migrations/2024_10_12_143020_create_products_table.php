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
            $table -> bigIncrements('id');
            $table -> unsignedBigInteger('user_id'); //登録したユーザー以外の商品表示に必要
            $table -> unsignedBigInteger('company_id');
            $table -> string('product_name', 255);
            $table -> integer('price');
            $table -> integer('stock');
            $table -> string('description', 255);
            $table -> string('img_path', 255);
            $table -> timestamps(); //'created_at'と'updated_at'をまとめてLaravelのデフォルトメソッドにかえる

            //外部キー制約
            $table -> foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table -> foreign('company_id') -> references('id') -> on('companies') -> onDelete('cascade');
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
