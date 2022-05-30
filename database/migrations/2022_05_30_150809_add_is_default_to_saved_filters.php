<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDefaultToSavedFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_savedfilters', function (Blueprint $table) {
            //
            $table->integer('is_default')->index()->after('is_global');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_savedfilters', function (Blueprint $table) {
            //
            $table->dropColumn('is_default');
        });
    }
}
