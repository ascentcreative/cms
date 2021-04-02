<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetupCMSTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cms_contactrequests', function(Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('message')->nullable();
            $table->float('recaptcha_score')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_header_images', function(Blueprint $table) {
            $table->id();
            $table->string('headerable_type', 50)->nullable();
            $table->integer('headerable_id')->nullable();
            $table->string('image')->nullable();
            $table->text('alt_text')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_menuitems', function(Blueprint $table) {
            $table->id();
            $table->integer('_lft')->nullable();
            $table->integer('_rgt')->nullable();
            $table->integer('menu_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('linkable_type')->nullable();
            $table->integer('linkable_id')->nullable();
            $table->string('url')->nullable();
            $table->integer('newWindow')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_menus', function(Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_pages', function(Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_settings', function(Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('value')->nullable();
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
        Schema::drop('cms_contactrequests');
        Schema::drop('cms_header_images');
        Schema::drop('cms_menu_items');
        Schema::drop('cms_menus');
        Schema::drop('cms_pages');
        Schema::drop('cms_settings');


    }
}
