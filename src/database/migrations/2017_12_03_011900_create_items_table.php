<?php

use Dekmabot\Catalog\app\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Item::TABLE, function (Blueprint $table){
            $table->increments(Item::FIELD_ID);
            $table->unsignedInteger(Item::FIELD_TYPE_ID);
            $table->unsignedInteger(Item::FIELD_BRAND_ID);
            $table->unsignedInteger(Item::FIELD_RUBRIC_ID)->nullable()->default(null);
            $table->string(Item::FIELD_CODE)->nullable()->default(null);
            $table->string(Item::FIELD_NAME);
            $table->string(Item::FIELD_SLUG);
            $table->text(Item::FIELD_TEXT)->nullable();
            $table->float(Item::FIELD_PRICE)->nullable()->default(null);
            $table->string(Item::FIELD_IMAGE)->nullable()->default(null);
            $table->float(Item::FIELD_RATING)->default(3);
            $table->boolean(Item::FIELD_IS_ACTIVE)->default(true);
            $table->boolean(Item::FIELD_IS_POPULAR)->default(true);
            $table->boolean(Item::FIELD_IS_NEW)->default(true);
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
        Schema::drop(Item::TABLE);
    }
}
