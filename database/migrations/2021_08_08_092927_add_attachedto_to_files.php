<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachedToToFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_files', function (Blueprint $table) {
            //
       
            $table->string('attachedto_type')->nullable();
            $table->integer('attachedto_id')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_files', function (Blueprint $table) {
            //
       
            $table->dropColumn('attachedto_type');
            $table->dropColumn('attachedto_id');


        });
    }
}
