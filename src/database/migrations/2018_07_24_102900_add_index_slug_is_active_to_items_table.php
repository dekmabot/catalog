<?php

use Dekmabot\Catalog\app\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexSlugIsActiveToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Item::TABLE, function (Blueprint $table){
            $table->index([Item::FIELD_SLUG, Item::FIELD_IS_ACTIVE]);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Item::TABLE, function (Blueprint $table){
            $table->dropIndex([Item::FIELD_SLUG, Item::FIELD_IS_ACTIVE]);
        });
    }
}
