<?php

use Dekmabot\Catalog\app\Models\TypeRubric;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesRubricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TypeRubric::TABLE, function (Blueprint $table){
            $table->increments(TypeRubric::FIELD_ID);
            $table->unsignedInteger(TypeRubric::FIELD_TYPE_ID);
            $table->unsignedInteger(TypeRubric::FIELD_RUBRIC_ID);
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
        Schema::drop(TypeRubric::TABLE);
    }
}
