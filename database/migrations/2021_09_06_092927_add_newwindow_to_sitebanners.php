<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewWindowToSiteBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_sitebanners', function (Blueprint $table) {
            //
       
            $table->integer('new_window')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_sitebanners', function (Blueprint $table) {
            //
       
          
            $table->dropColumn('new_window');


        });
    }
}
