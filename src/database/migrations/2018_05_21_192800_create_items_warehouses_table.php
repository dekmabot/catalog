<?php

use Dekmabot\Catalog\app\Models\ItemWarehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ItemWarehouse::TABLE, function (Blueprint $table){
            $table->increments(ItemWarehouse::FIELD_ID);
            $table->unsignedInteger(ItemWarehouse::FIELD_ITEM_ID);
            $table->unsignedInteger(ItemWarehouse::FIELD_WAREHOUSE_ID);
            $table->unsignedInteger(ItemWarehouse::FIELD_VALUE);
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
        Schema::drop(ItemWarehouse::TABLE);
    }
}
