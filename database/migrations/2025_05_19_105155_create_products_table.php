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
            $table->id(); // ID（自動採番）
            $table->string('name'); // 商品名
            $table->unsignedBigInteger('company_id'); // メーカーID（外部キー）
            $table->integer('price'); // 価格
            $table->integer('stock'); // 在庫数
            $table->text('comment')->nullable(); // コメント（任意）
            $table->string('image')->nullable(); // 商品画像（任意）
            $table->timestamps(); // created_at, updated_at

            // 外部キー制約（companiesテーブルのidを参照）
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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