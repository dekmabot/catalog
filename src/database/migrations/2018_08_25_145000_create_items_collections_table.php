<?php

use Dekmabot\Catalog\app\Models\ItemCollection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ItemCollection::TABLE, function (Blueprint $table){
            $table->increments(ItemCollection::FIELD_ID);
            $table->unsignedInteger(ItemCollection::FIELD_ITEM_ID);
            $table->unsignedInteger(ItemCollection::FIELD_COLLECTION_ID);
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
        Schema::drop(ItemCollection::TABLE);
    }
}
