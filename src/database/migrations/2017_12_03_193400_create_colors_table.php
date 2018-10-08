<?php

use Dekmabot\Catalog\app\Models\Color;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Color::TABLE, function (Blueprint $table){
            $table->increments(Color::FIELD_ID);
            $table->unsignedSmallInteger(Color::FIELD_POS);
            $table->string(Color::FIELD_NAME);
            $table->string(Color::FIELD_HEX);
            $table->boolean(Color::FIELD_IS_ACTIVE)->default(true);
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
        Schema::drop(Color::TABLE);
    }
}
