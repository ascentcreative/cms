<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SplitUserNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //echo 'upping';
        Schema::table('users', function(Blueprint $table) {

            $table->string('last_name', 255)->after('name');
            $table->renameColumn('name', 'first_name');
            

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
        Schema::table('users', function(Blueprint $table) {

            $table->renameColumn('first_name', 'name');
            $table->dropColumn('last_name');

        });
    }
}
