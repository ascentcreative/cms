<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeContentStackTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cms_stacks', function(Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->index('name');
            $table->string('slug', 50);
            $table->index('slug');
            $table->timestamps();
        });

        Schema::create('cms_block_templates', function(Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->index('name');
            $table->string('slug', 50);
            $table->index('slug');
            $table->text('description');
            $table->timestamps();
        });


        Schema::create('cms_blocks', function(Blueprint $table) {
            $table->id();
            $table->integer('stack_id');
            $table->index('stack_id');
            $table->integer('blocktemplate_id');
            $table->index('blocktemplate_id');
            $table->string('name', 50);
            $table->index('name');
            $table->string('slug', 50);
            $table->index('slug');
            $table->text('data');
            $table->integer('sort');
            $table->index('sort');
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
        Schema::drop('cms_stacks');
        Schema::drop('cms_block_templates');
        Schema::drop('cms_blocks');
    }
}
