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
        Schema::create('users', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> string('name');
            $table -> string('name_kanji');
            $table -> string('name_kana')->nullable();;
            $table -> string('email') -> unique();
            $table -> string('password');
            $table -> unsignedBigInteger('company_id') -> nullable();
            $table -> timestamps();

            // 外部キー制約
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
