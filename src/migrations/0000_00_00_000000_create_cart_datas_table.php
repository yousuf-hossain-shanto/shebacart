<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cart_type');
            $table->string('product_type');
            $table->bigInteger('product_id');
            $table->string('user_type');
            $table->bigInteger('user_id');
            $table->bigInteger('quantity')->default(1);
            $table->string('price')->default(0);
            $table->longText('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_datas');
    }
}
