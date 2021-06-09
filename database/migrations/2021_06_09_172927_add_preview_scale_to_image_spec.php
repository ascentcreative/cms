<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviewScaleToImageSpec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_image_specs', function (Blueprint $table) {
            //
            $table->float('preview_scale')->after('height');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_image_specs', function (Blueprint $table) {
            //
            $table->dropColumn('preview_scale');
        });
    }
}
