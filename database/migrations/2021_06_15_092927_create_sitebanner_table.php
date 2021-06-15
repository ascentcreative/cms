<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_sitebanners', function (Blueprint $table) {
            //
           $table->id();

           $table->string('title');

            $table->integer('image_id');
            $table->string('link_url')->nullable();
            $table->string('bgcolor', 20)->nullable();

           $table->integer('publishable')->nullable();
           $table->date('start_date')->nullable();
           $table->date('end_date')->nullable();

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
        Schema::dropIfExists('cms_sitebanners');
    }
}
