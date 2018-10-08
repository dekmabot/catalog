<?php

use Dekmabot\Catalog\app\Models\Brand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Brand::TABLE, function (Blueprint $table){
            $table->increments(Brand::FIELD_ID);
            $table->string(Brand::FIELD_NAME);
            $table->string(Brand::FIELD_SLUG);
            $table->text(Brand::FIELD_TEXT_SHORT)->nullable();
            $table->longText(Brand::FIELD_TEXT_LONG)->nullable();
            $table->string(Brand::FIELD_IMAGE)->nullable()->default(null);
            $table->boolean(Brand::FIELD_IS_ACTIVE)->default(true);
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
        Schema::drop(Brand::TABLE);
    }
}
