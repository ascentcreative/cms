<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;
use AscentCreative\CMS\Models\MenuItem;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class MenuItemController extends AdminBaseController
{

    static $modelClass = 'AscentCreative\CMS\Models\MenuItem';
    static $bladePath = "cms::admin.menuitems";


    /**
     *  Dealing with NESTED SET Models, so I'm going to override Index to return the tree, not a flat list 
     * 
     * Feels like the main controller should handle this, but this'll do for now...
     * 
    */
    public function index()
    {

        $items = ($this::$modelClass)::scoped([ 'menu_id' => 1 ])->withDepth()->orderBy('_lft')->get(); //->toTree();

        return view($this::$bladePath . '.index', $this->prepareViewData())->with('models', $items);

    }


    /**
     * Overriding this and the save process isn't straightforward on a nested model.
     */
    public function commitModel(Request $request, Model $model)
    {

    
      //  dd($request->all());
      
      $model->fill($request->all());
       $model->menu_id = $request->menu_id;
       $model->title = $request->title;

       $context = MenuItem::find($request->context_id);

        

       if($context) {
          
            switch($request->context_type) {
                case 'first-child':
                    $model->prependToNode($context);
                    break;
                case 'before':
                    $model->beforeNode($context);
                    break;
                case 'after':
                    $model->afterNode($context);
                    break;
            }
        } else {
            
        }

       $model->save();

    }
    


    public function rules($request, $model=null) {

       return [
            'title' => 'required',
        ]; 

    }


    public function autocomplete(Request $request, string $term) {

        echo $term;

    }



}