<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class SettingsController extends AdminBaseController
{

    static $modelClass = 'AscentCreative\CMS\Models\Setting';
    static $bladePath = "cms::admin.settings";

    

    public function commitModel(Request $request, Model $model) {

        $model->fill([
            'name' => request()->name,
            'value' => json_encode(request()->value)
         //   $request->all())
        ]);
        $model->save();

    }


    public function rules($request, $model=null) {

        return [
         //    'title' => 'required',
         ]; 
 
     }


}