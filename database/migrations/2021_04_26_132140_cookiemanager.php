<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cookiemanager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cms_cookietypes', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->index('title');
            $table->string('slug');
            $table->index('slug');
            $table->text('description');
            $table->integer('mandatory');
            $table->integer('sort');
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
        //
        Schema::drop('cms_cookietypes');
    }
}
