<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class RoleController extends AdminBaseController
{

    static $modelClass = 'Spatie\Permission\Models\Role';
    static $bladePath = "cms::admin.roles";


    public function commitModel(Request $request, Model $model) {

        $model->guard_name = 'web';
        // Save the Cheerleader (User)
        parent::commitModel($request, $model); 

        // $model->syncRoles($request->roles);
        $model->syncPermissions($request->permissions);

    }



    public function rules($request, $model=null) {

       return [
            'name' => 'required'
        ]; 

    }


    public function autocomplete(Request $request, string $term) {

        echo $term;

    }



}