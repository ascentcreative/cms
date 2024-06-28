<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class PageController extends AdminBaseController
{

   // static $modelClass = 'AscentCreative\CMS\Models\Page';

    static $modelClass = 'Page';
    static $bladePath = "cms::admin.pages";

    public $indexSort = 'title';
    public $indexSearchFields = ['title', 'content'];

    public $ignoreScopes = ['published'];

    public function commitModel(Request $request, Model $model)
    {

      
    //    MenuItem::linkThis($this, $request->context_id, $request->context_type);
      //  dd(request()->all());
      
      // $model->fillExtenders($request->all());
       $model->fill($request->all());
       $model->save();

     //  dd($request->all());


       // $Fillable prevents non-model data being sent to the DB.
       // Now we've got the model saved, we can fire off the extensions to other models / relationships
       // Would really love to make this configurable (like model plugins on Zend)

       // problem is that starts to relate to adding fields directly to the edit screen with names to 
       // match expected incoming data, and that's where ModelPlugins got hugely complex.
       // But there's a reason I went that way with the strucutre...

       

        //dd($incoming);
       
    }
    


    public function rules($request, $model=null) {

        $rules = [
            'title' => 'required',
        ];

        if(config('cms.content_editor') == 'stackeditor') {
            $rules = array_merge(
                $rules,
                \AscentCreative\StackEditor\View\Components\Stack::getRules('content', $request->content)
            );
        }

       return $rules;

    }

    public function messages($request, $model=null) : array {

        $msgs = [];
        
        if(config('cms.content_editor') == 'stackeditor') {
            $msgs = array_merge(
                $msgs,
                \AscentCreative\StackEditor\View\Components\Stack::getMessages('content', $request->content)
            );
        }

        return $msgs;

    }


    public function autocomplete(Request $request, string $term) {  

        echo $term;

    }



}