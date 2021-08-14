<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{

    /* even though the page model is defined here, the bindings swap the class at runtime */
    public function show(\AscentCreative\CMS\Models\Page $page, $forceHTML=false ) {

        if(Route::currentRouteName() != 'homepage') {
            headTitle()->add($page->title);
        }
        
        if (request()->wantsJson() && !$forceHTML) {
            return view('cms::public.pages.modal')->withModel($page);
        } else {
            return view('cms::public.pages.show')->withModel($page);
        }
    
    }

}
