<?php

use Dekmabot\Catalog\app\Models\ItemWarehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexWarehouseIdToItemsWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(ItemWarehouse::TABLE, function (Blueprint $table){
            $table->index([ItemWarehouse::FIELD_ITEM_ID, ItemWarehouse::FIELD_WAREHOUSE_ID]);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(ItemWarehouse::TABLE, function (Blueprint $table){
            $table->dropIndex([ItemWarehouse::FIELD_ITEM_ID, ItemWarehouse::FIELD_WAREHOUSE_ID]);
        });
    }
}
