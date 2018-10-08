<?php

use Dekmabot\Catalog\app\Models\ItemColor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexColorIdToItemsColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(ItemColor::TABLE, function (Blueprint $table){
            $table->index([ItemColor::FIELD_ITEM_ID, ItemColor::FIELD_COLOR_ID]);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(ItemColor::TABLE, function (Blueprint $table){
            $table->dropIndex([ItemColor::FIELD_ITEM_ID, ItemColor::FIELD_COLOR_ID]);
        });
    }
}
