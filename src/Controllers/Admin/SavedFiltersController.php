<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class SavedFiltersController extends AdminBaseController
{

    static $modelClass = 'AscentCreative\CMS\Models\SavedFilter';
    static $bladePath = "cms::admin.savedfilters";

   
    public function rules($request, $model=null) {

       return [
            'name' => 'required',
        ]; 

    }


}