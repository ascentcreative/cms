<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PublishablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            //
        

           $table->integer('publishable')->nullable();
           $table->date('publish_start')->nullable();
           $table->date('publish_end')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('cms_pages', function (Blueprint $table) {
            //
        

           $table->dropColumn('publishable')->nullable();
           $table->dropColumn('publish_start')->nullable();
           $table->dropColumn('publish_end')->nullable();


        });
       
    }
}
