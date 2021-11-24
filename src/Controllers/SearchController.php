<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class SearchController extends Controller
{

    public function search() {
       
        $query = request()->query('query');

        // empty results collection
        $results = collect([]);

         // find all the indexed models
         $modelDirectories = config('scout.mysql.model_directories');
       
        // search all the models and combine into a single collection
        foreach( app('Yab\MySQLScout\Services\IndexService')->getAllSearchableModels($modelDirectories) as $cls) {
            $hits = $cls::search($query)->get();
            // got the $hits?
            if(!is_null($hits)) {
                $results = $results->concat($hits);
            }
        }

        // sort by relevance
        $results = $results->sortByDesc('relevance'); //, 'desc');
    
        // output
        foreach($results as $result) {
            // echo '<P>' . get_class($result) . ' :: <A href="' . $result->url . '">' . $result->title . "</A> :: (" . $result->relevance . ")";
        }

        // return view('base');
        return view('search.results', ['results'=>$results]);
        

    }

}
