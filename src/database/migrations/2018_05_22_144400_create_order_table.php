<?php

use Dekmabot\Catalog\app\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Order::TABLE, function (Blueprint $table){
            $table->increments(Order::FIELD_ID);
            $table->unsignedInteger(Order::FIELD_USER_ID)->nullable()->default(null);
            $table->string(Order::FIELD_CODE)->nullable()->default(null);
            $table->string(Order::FIELD_FIRST_NAME)->nullable()->default(null);
            $table->string(Order::FIELD_SECOND_NAME)->nullable()->default(null);
            $table->string(Order::FIELD_SURNAME)->nullable()->default(null);
            $table->string(Order::FIELD_PHONES)->nullable()->default(null);
            $table->string(Order::FIELD_ADDRESS)->nullable()->default(null);
            $table->string(Order::FIELD_CITY)->nullable()->default(null);
            $table->unsignedSmallInteger(Order::FIELD_LEGAL)->nullable()->default(null);
            $table->unsignedInteger(Order::FIELD_DELIVERY)->nullable()->default(null);
            $table->unsignedSmallInteger(Order::FIELD_STATUS)->default(Order::STATUS_NEW);
            $table->unsignedInteger(Order::FIELD_COUNT_ITEMS)->nullable()->default(null);
            $table->unsignedInteger(Order::FIELD_COUNT_TOTAL)->nullable()->default(null);
            $table->unsignedInteger(Order::FIELD_SUM)->nullable()->default(null);
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
        Schema::drop(Order::TABLE);
    }
}
