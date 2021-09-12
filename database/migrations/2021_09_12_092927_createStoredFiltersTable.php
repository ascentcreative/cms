<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_savedfilters', function (Blueprint $table) {
            //
            $table->id();

            $table->string('name')->index();
            $table->string('slug')->index();
            $table->string('url')->index();
            $table->string('filter')->index();
            $table->integer('user_id')->index();
            $table->boolean('is_global')->index();

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
        Schema::dropIfExists('cms_savedfilters');
    }
}
