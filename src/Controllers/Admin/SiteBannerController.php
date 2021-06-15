<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class SiteBannerController extends AdminBaseController
{

    static $modelClass = 'AscentCreative\CMS\Models\SiteBanner';
    static $bladePath = "cms::admin.sitebanners";



    public function rules($request, $model=null) {

       return [
            'title' => 'required',
        ]; 

    }


    public function autocomplete(Request $request, string $term) {

        echo $term;

    }



}