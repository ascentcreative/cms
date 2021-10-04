<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePermissionsToCMSUserModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        // \DB::update(
        //     \DB::Raw("
        //     update model_has_roles
        //     set model_type = 'AscentCreative\\CMS\\Models\\User'
        //     where model_type = 'App\\Models\\User';
        //     ")
        // );
          
        // \DB::update(
        //     \DB::Raw("
        //     update model_has_permissions
        //     set model_type = 'AscentCreative\\CMS\\Models\\User'
        //     where model_type = 'App\\Models\\User';
        //     ")
        // );

        DB::table('model_has_permissions')
              ->where('model_type', 'App\Models\User')
              ->update(['model_type' => 'AscentCreative\CMS\Models\User']);

        DB::table('model_has_roles')
              ->where('model_type', 'App\Models\User')
              ->update(['model_type' => 'AscentCreative\CMS\Models\User']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // \DB::update(
        //     \DB::Raw("
        //     update model_has_roles
        //     set model_type =  'App\\Models\\User'
        //     where model_type = 'AscentCreative\\CMS\\Models\\User';
        //     ")
        // );
          
        // \DB::update(
        //     \DB::Raw(" 
        //     update model_has_permissions
        //     set model_type =  'App\\Models\\User'
        //     where model_type = 'AscentCreative\\CMS\\Models\\User';
        //     ")
        // );

        DB::table('model_has_permissions')
            ->where('model_type', 'AscentCreative\CMS\Models\User')
            ->update(['model_type' => 'App\Models\User']);

        DB::table('model_has_roles')
            ->where('model_type', 'AscentCreative\CMS\Models\User')
            ->update(['model_type' => 'App\Models\User']);

    }
}
