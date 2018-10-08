<?php

use Dekmabot\Catalog\app\Models\ItemOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ItemOption::TABLE, function (Blueprint $table){
            $table->increments(ItemOption::FIELD_ID);
            $table->unsignedInteger(ItemOption::FIELD_ITEM_ID);
            $table->unsignedInteger(ItemOption::FIELD_OPTION_ID);
            $table->longText(ItemOption::FIELD_VALUE);
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
        Schema::drop(ItemOption::TABLE);
    }
}
