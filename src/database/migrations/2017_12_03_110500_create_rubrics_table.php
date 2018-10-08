<?php

use Dekmabot\Catalog\app\Models\Rubric;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateRubricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Rubric::TABLE, function (Blueprint $table){
            $table->increments(Rubric::FIELD_ID);
            $table->string(Rubric::FIELD_NAME);
            $table->string(Rubric::FIELD_NAME_SHORT)->nullable()->default(null);
            $table->string(Rubric::FIELD_SLUG);
            $table->text(Rubric::FIELD_TEXT)->nullable();
            $table->string(Rubric::FIELD_URL)->nullable()->default(null);
            $table->string(Rubric::FIELD_IMAGE_ANNOUNCE)->nullable()->default(null);
            $table->string(Rubric::FIELD_IMAGE_PROMO)->nullable()->default(null);
            $table->boolean(Rubric::FIELD_IS_ACTIVE)->default(true);
            $table->softDeletes();
            $table->timestamps();

            NestedSet::columns($table);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Rubric::TABLE);
    }
}
