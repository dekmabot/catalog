<?php

use Dekmabot\Catalog\app\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchIndexToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Item::TABLE, function (Blueprint $table){
            $table->index(Item::$indexes[Item::INDEX_SEARCH], Item::INDEX_SEARCH);
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
            $table->dropIndex(Item::INDEX_SEARCH);
        });
    }
}
