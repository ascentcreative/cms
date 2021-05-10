<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use AscentCreative\CMS\Models\ImageSpec;

class SetupCMSImageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::dropIfExists('cms_header_images');

        Schema::create('cms_images', function(Blueprint $table) {
            $table->id();
            $table->string('imageable_type', 50)->nullable();
            $table->integer('imageable_id')->nullable();
            $table->integer('image_spec_id')->nullable();
            $table->string('image')->nullable();
            $table->text('alt_text')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_image_specs', function(Blueprint $table) {
            $table->id();
            $table->string('title', 50)->nullable();
            $table->string('slug')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->float('quality')->nullable();
            $table->timestamps();
        });

        // ImageSpec::create([
        //     'title'=>'Header',
        //     'width'=>2000,
        //     'height'=>600,
        //     'quality'=>0.6
        // ]);
        

        // ImageSpec::create([
        //     'title'=>'Thumbnail',
        //     'width'=>400,
        //     'height'=>400,
        //     'quality'=>0.6
        // ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('cms_images');
        Schema::drop('cms_image_specs');

        Schema::create('cms_header_images', function(Blueprint $table) {
            $table->id();
            $table->string('headerable_type', 50)->nullable();
            $table->integer('headerable_id')->nullable();
            $table->string('image')->nullable();
            $table->text('alt_text')->nullable();
            $table->timestamps();
        });

    }
}
