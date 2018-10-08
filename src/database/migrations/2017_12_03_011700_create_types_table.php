<?php

use Dekmabot\Catalog\app\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Type::TABLE, function (Blueprint $table){
            $table->increments(Type::FIELD_ID);
            $table->string(Type::FIELD_NAME);
            $table->boolean(Type::FIELD_IS_ACTIVE)->default(true);
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
        Schema::drop(Type::TABLE);
    }
}
