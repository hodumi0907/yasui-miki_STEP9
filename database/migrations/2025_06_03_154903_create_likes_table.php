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
        Schema::create('likes', function (Blueprint $table) {
            $table -> bigIncrements('id');  // bigintのauto increment
            $table -> unsignedBigInteger('user_id');
            $table -> unsignedBigInteger('product_id');
            $table -> timestamps(); // created_at, updated_at はnullableなのでそのままでOK

            // 外部キー制約追加
            $table -> foreign('user_id') -> references('id')-> on('users') -> onDelete('cascade');
            $table -> foreign('product_id') -> references('id') -> on('products') -> onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
