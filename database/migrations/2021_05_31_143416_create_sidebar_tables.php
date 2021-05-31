<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSidebarTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cms_sidebar_panels', function (Blueprint $table) {

            $table->id();
            $table->string('sidebarable_type')->index();
            $table->integer('sidebarable_id')->index();
            $table->string('sidebar_section')->index();
            $table->string('panel_class')->index();
            $table->text('data');
            $table->integer('sort')->index();
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
        Schema::dropIfExists('cms_sidebar_panels');
    }
}
