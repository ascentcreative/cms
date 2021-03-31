<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Models\Page;


class PageController extends Controller
{

  public function show(Page $page) {

    if (request()->wantsJson()) {
        return view('cms::public.pages.modal')->withModel($page);
    } else {
        return view('cms::public.pages.show')->withModel($page);
    }
    

  }

}
