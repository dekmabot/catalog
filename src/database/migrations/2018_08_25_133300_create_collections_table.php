<?php

use Dekmabot\Catalog\app\Models\Collection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Collection::TABLE, function (Blueprint $table){
            $table->increments(Collection::FIELD_ID);
            $table->integer(Collection::FIELD_POS)->default(0);
            $table->string(Collection::FIELD_SLUG);
            $table->string(Collection::FIELD_NAME);
            $table->text(Collection::FIELD_TEXT)->nullable();
            $table->string(Collection::FIELD_IMAGE)->nullable()->default(null);
            $table->boolean(Collection::FIELD_IS_ACTIVE)->default(true);
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
        Schema::drop(Collection::TABLE);
    }
}
