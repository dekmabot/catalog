<?php

use Dekmabot\Catalog\app\Models\ItemOrder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ItemOrder::TABLE, function (Blueprint $table){
            $table->increments(ItemOrder::FIELD_ID);
            $table->unsignedInteger(ItemOrder::FIELD_ITEM_ID);
            $table->unsignedInteger(ItemOrder::FIELD_ORDER_ID);
            $table->float(ItemOrder::FIELD_PRICE);
            $table->smallInteger(ItemOrder::FIELD_COUNT);
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
        Schema::drop(ItemOrder::TABLE);
    }
}
