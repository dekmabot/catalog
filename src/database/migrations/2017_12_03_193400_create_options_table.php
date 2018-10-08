<?php

use Dekmabot\Catalog\app\Models\Option;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Option::TABLE, function (Blueprint $table){
            $table->increments(Option::FIELD_ID);
            $table->string(Option::FIELD_NAME);
            $table->string(Option::FIELD_SLUG);
            $table->integer(Option::FIELD_TYPE);
            $table->longText(Option::FIELD_PARAMS);
            $table->boolean(Option::FIELD_IS_ACTIVE)->default(true);
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
        Schema::drop(Option::TABLE);
    }
}
