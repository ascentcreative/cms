<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->publishable();
        });

        $pages = \AscentCreative\CMS\Models\Page::withoutGlobalScope('published')->update(['publishable'=>1]);
    }

    public function down()
    {
        Schema::table('cms_files', function (Blueprint $table) {
            $table->dropPublishable();
        });
    }

};
