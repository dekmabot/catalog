<?php

use Dekmabot\Catalog\app\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Warehouse::TABLE, function (Blueprint $table){
            $table->increments(Warehouse::FIELD_ID);
            $table->unsignedInteger(Warehouse::FIELD_POINT_ID)->nullable()->default(null);
            $table->string(Warehouse::FIELD_CODE)->nullable()->default(null);
            $table->string(Warehouse::FIELD_NAME);
            $table->string(Warehouse::FIELD_NAME_SHORT)->nullable()->default(null);
            $table->string(Warehouse::FIELD_SLUG);
            $table->unsignedSmallInteger(Warehouse::FIELD_POS);
            $table->longText(Warehouse::FIELD_TEXT)->nullable()->default(null);
            $table->string(Warehouse::FIELD_ADDRESS)->nullable()->default(null);
            $table->string(Warehouse::FIELD_PHONE)->nullable()->default(null);
            $table->string(Warehouse::FIELD_PHONE2)->nullable()->default(null);
            $table->string(Warehouse::FIELD_PHONE3)->nullable()->default(null);
            $table->string(Warehouse::FIELD_WORKING_HOURS_WEEK)->nullable()->default(null);
            $table->string(Warehouse::FIELD_WORKING_HOURS_WEEKEND)->nullable()->default(null);
            $table->boolean(Warehouse::FIELD_IS_ACTIVE)->default(true);
            $table->boolean(Warehouse::FIELD_IS_MAIN)->default(false);
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
        Schema::drop(Warehouse::TABLE);
    }
}
