<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Models\Page;


class PageController extends Controller
{

  public function show(Page $page) {

    return view('cms::public.pages.show')->withModel($page);

  }

}
