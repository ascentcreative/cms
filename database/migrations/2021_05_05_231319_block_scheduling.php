<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BlockScheduling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cms_blocks', function(Blueprint $table) {
            $table->integer('published')->after('blocktemplate_id');
            $table->timestamp('start_date')->nullable()->after('published');
            $table->timestamp('end_date')->nullable()->after('start_date');
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
        Schema::table('cms_blocks', function(Blueprint $table) {
            $table->dropColumn('published');
            $table->dropColumn('start_date')->nullable();
            $table->dropColumn('end_date')->nullable();
        });


    }
}
