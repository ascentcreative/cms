<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class UserController extends AdminBaseController
{

    //static $modelClass = 'App\Models\User';
    static $modelClass = 'AscentCreative\CMS\Models\User';
    static $bladePath = "cms::admin.users";


    public function commitModel(Request $request, Model $model) {

        // Save the Cheerleader (User)
        parent::commitModel($request, $model); 

        // Save the World (Permissions & Roles)
        print_r($request->roles);

        $model->syncRoles($request->roles);
        $model->syncPermissions($request->permissions);

    }



    public function rules($request, $model=null) {

       return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email'
        ]; 

    }


    public function autocomplete(Request $request, string $term) {

        echo $term;

    }



}