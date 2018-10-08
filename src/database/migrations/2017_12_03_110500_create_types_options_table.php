<?php

use Dekmabot\Catalog\app\Models\TypeOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TypeOption::TABLE, function (Blueprint $table){
            $table->increments(TypeOption::FIELD_ID);
            $table->unsignedInteger(TypeOption::FIELD_TYPE_ID);
            $table->unsignedInteger(TypeOption::FIELD_OPTION_ID);
            $table->integer(TypeOption::FIELD_SORT);
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
        Schema::drop(TypeOption::TABLE);
    }
}
