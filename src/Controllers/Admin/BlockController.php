<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class BlockController extends AdminBaseController
{

    static $modelClass = 'AscentCreative\CMS\Models\Block';
    static $bladePath = "cms::admin.blocks";



    public function rules($request, $model=null) {

       return [
            'name' => 'required',
        ]; 

    }


    public function autocomplete(Request $request, string $term) {

        echo $term;

    }



}