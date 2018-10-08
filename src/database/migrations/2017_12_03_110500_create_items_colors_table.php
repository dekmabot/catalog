<?php

use Dekmabot\Catalog\app\Models\ItemColor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ItemColor::TABLE, function (Blueprint $table){
            $table->increments(ItemColor::FIELD_ID);
            $table->unsignedInteger(ItemColor::FIELD_ITEM_ID);
            $table->unsignedInteger(ItemColor::FIELD_COLOR_ID);
            $table->string(ItemColor::FIELD_IMAGE)->nullable()->default(null);
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
        Schema::drop(ItemColor::TABLE);
    }
}
