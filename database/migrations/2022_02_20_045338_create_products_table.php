<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36);

            //Foreign Key With User Table Id
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            //Product Fields
            $table->string('product_name')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('price', 7, 2)->nullable();
            $table->integer('buy_min_quantity')->nullable();
            $table->integer('buy_max_quantity')->nullable();
            $table->mediumText('description')->nullable();
            $table->tinyInteger('is_status')->default(1)->comment('1=Active 0=Inactive');
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
        Schema::dropIfExists('products');
    }
}
