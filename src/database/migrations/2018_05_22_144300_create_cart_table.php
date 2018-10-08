<?php

use Dekmabot\Catalog\app\Models\Cart;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Cart::TABLE, function (Blueprint $table){
            $table->increments(Cart::FIELD_ID);
            $table->unsignedInteger(Cart::FIELD_ITEM_ID);
            $table->unsignedInteger(Cart::FIELD_ORDER_ID)->nullable()->default(null);
            $table->unsignedInteger(Cart::FIELD_USER_ID)->nullable()->default(null);
            $table->string(Cart::FIELD_SESSION)->nullable()->default(null);
            $table->float(Cart::FIELD_PRICE);
            $table->longText(Cart::FIELD_COUNT);
            $table->softDeletes();
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
        Schema::drop(Cart::TABLE);
    }
}
