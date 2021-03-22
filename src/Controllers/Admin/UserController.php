<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class UserController extends AdminBaseController
{

    static $modelClass = 'App\Models\User';
    static $bladePath = "cms::admin.users";


    public function rules($request, $model=null) {

       return [
            'title' => 'required',
        ]; 

    }


    public function autocomplete(Request $request, string $term) {

        echo $term;

    }



}