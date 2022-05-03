<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

use AscentCreative\CMS\Admin\UI\Index\Column;
use AscentCreative\CMS\Filters\FilterManager;
 
use Illuminate\Database\Eloquent\Model;

abstract class AdminBaseController extends Controller
{

    static $modelClass = 'DEFINE_ME';
    static $bladePath = 'define.me';

    public $modelName = null; // override if the class name doesn't parse nicely.
    public $modelNameHuman = null;
    public $modelPlural = null; // override this if the auto-plural fails spectacularly...

    public $authorize = [];

    public $pageSize = 15;
    public $indexSort = array();
    public $indexSearchFields = array();
    public $indexSelectable = true;
    public $indexEagerLoad = [];
    public $indexEagerLoadSum = [];
    public $indexEagerLoadCount = [];

    public $ignoreScopes = array();

    public $allowDeletions = true;

    public $_columns = array();

    private $_filters = array();

    protected $_filtermanager;

    public function __construct() {
        //parent::__construct();
        $this->_filtermanager = new FilterManager();

    }



    /** Function to check for locally override blades */
    public function resolveBlade($action) {

        $path = $this::$bladePath . '.' . $action;
        $overridePath = str_replace('::', '.', $path);

        if(view()->exists($overridePath)) {
            return $overridePath;
        } else {
            return $path;
        }

    }

    /**
     * Creates an array of the generic data points used by the view
     * (i.e. model name, plural, etc)
     */
    public function prepareViewData() {

        $ary = explode('\\', $this::$modelClass);
        $short = array_pop($ary);

        $modelName = $short ?? $this->modelName;

        $modelNameHuman = $this->modelNameHuman ?? trim(join(' ', preg_split('/(?=[A-Z])/',$modelName)));

        $out = array(
            'modelInject' => Str::lower($modelName),
            'modelName' => $modelNameHuman,
            'modelPlural' => (Str::pluralStudly($modelNameHuman) ?? $this->modelPlural),

            'rowClassResolvers' => $this->getRowClassResolvers(),
        );

        headTitle()->add($out['modelPlural']);

        return $out;

    }


    /**
     * Prepare a model::query()
     * Applies any necessary steps (such as global scope removal)
     */

     protected function prepareModelQuery() {

        $cls = $this::$modelClass;

        $qry = $cls::query();
        // remove any scopes as rewquested:
        foreach($this->ignoreScopes as $scopeName) {
            $qry->withoutGlobalScope($scopeName);
        }

        return $qry;
        

     }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        session(['index_load_start'=>microtime(true)]);

        // get the items for the view
        $items = $this->prepareModelQuery();


        // Eager Loading:
        foreach($this->indexEagerLoad as $with) {
            $items->with($with);
        }

        foreach($this->indexEagerLoadSum as $rel=>$prop) {
            $items->withSum($rel, $prop);
        }

        foreach($this->indexEagerLoadCount as $withCount) {
            $items->withCount($withCount);
        }
        

        // apply search string:

       if(isset($_GET['search'])) {

            foreach($this->indexSearchFields as $srch) {

                $val = $_GET['search'];
               // echo $_GET['search'];
                if (strstr($srch, '.') !== false) {

                    // relationship...
                    // Last part of the string is the property
                    $parts = explode('.', $srch);
                    $prop = array_pop($parts);
                    $srch = join('.', $parts);

                    $items->orWhereHas($srch, function($query) use ($prop, $val) { 
                        $query->where($prop, 'LIKE', '%' . $val . '%');
                    });

                } else {
                    $items->orWhere($srch, 'LIKE', '%' . $val . '%');
                }


            }

        } 

        $columns = $this->buildColumns();

        // prepare any defined filters...

        // if (is_array($this->_filters)) {
        //     foreach($this->_filters as $filter) {
        //         $items = $filter->applyFilter($items);
        //     }
        // }

        $fm = $this->_filtermanager;
        $fm->filter_wrapper = 'cfilter';

        foreach($columns as $col) {
            if($col->filterable) {
                $fm->registerFilter($col->slug, $col->filterScope);
            }

            if($col->sortable) {
                $fm->registerSorter($col->slug, $col->sortQuery);
            }
        }

        $items = $fm->apply($items);

        
        if (!is_array($this->indexSort)) {
            $this->indexSort = array($this->indexSort);
        }

        foreach($this->indexSort as $sort) {
            if (is_array($sort)) {
                $col = $sort[0];
                $dir = $sort[1];
            } else {
                $col = $sort;
                $dir = 'asc';
            }
            $items = $items->orderBy($col, $dir);
        }


        session(['last_index'=> url()->full()]);
       
        /** 
         * Sort out the page size 
         * 
         * If it's set in the request, use it
         * Otherwise, check the session
         * Failing that, pull it from the controller's default
        */
        $pageSize = request()->pageSize ?? (session('pageSize_' . request()->path()) ?? $this->pageSize);

        // Once we know the page size, write it to the session for next access
        session(['pageSize_' . request()->path() => $pageSize]);
        // Plus, if it didn't come from the request, set it, so the UI can show the right selected value in the dropdown
        request()->pageSize = $pageSize;

        //\Log::info("*** RUNNING INDEX QUERY(S) ***");

        // And finally, use the page size to paginate the query
        if (is_numeric($pageSize)) {
            $items = $items->paginate($pageSize)->withQueryString();
        } else {
            // this won't happen - was going to be for an ALL setting, but problematic for the view info display.
           $items = $items->get();
        }

        //\Log::info("*** INDEX QUERY(S) COMPLETE ***");

        

        return view($this->resolveBlade('index'), $this->prepareViewData())
                        ->with('models', $items)
                        ->with('columns', $columns);

    }

    /**
     * overridable function where the columns are defined
     *
     * @return array of column objects
     */
    public function getColumns() : array {
        return [];
    }

    public function getRowClassResolvers() : array {
        return [];
    }

    /**
     * Takes the getColumns() output and makes core adjustments (like adding selection checkboxes and delete / context menu)
     * 
     * @return array of column objects
     */
    public function buildColumns() : array {
        
        $cols = $this->getColumns();

        if ($this->indexSelectable) {

            array_unshift($cols,
                Column::make()
                ->titleBlade('cms::admin.ui.index.checkalltoggle')
                    ->valueBlade('cms::admin.ui.index.selectcolumn')
                    ->width('1%')
            );

        }

        if($amCol = $this->buildActionMenuColumn()) {
            array_push($cols,
                $amCol
            );
        }

        return $cols;

    }


    public function buildActionMenuColumn() {
        return Column::make()
                ->titleBlade('cms::admin.ui.index.clearfilters')
                ->valueBlade('cms::admin.ui.index.actionmenu')
                ->align('right')
                ->width('1%');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $cls = $this->modelClass;
        return $this->edit(); //ew $cls());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $validatedData = $request->validate(
        //     $this->rules($request)
        // );

        Validator::make($request->all(), 
                    $this->rules($request),
                    $this->messages($request)
                    )->validate();

       // $cls = $this::$modelClass;
        $model = ($this::$modelClass)::make(); //new $cls();
       
        $this->commitModel($request, $model);

        if($request->wantsJson()) {
            return $model;
        } else {
            return redirect()->to($request->_postsave);
        }
        
  
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {

        $cls = $this::$modelClass;
        
        if (is_null($id)) {
         
            $model = ($this::$modelClass)::make(); //new $cls();
       
        } else {
            $model = $cls::find($id);
        }
       
        return view($this::$bladePath . '.show', $this->prepareViewData())->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=null)
    {
        $cls = ($this::$modelClass);
        
        if (is_null($id)) {

            $model = ($this::$modelClass)::make();
            $model->fill(request()->all()); //new $cls();

        } else {
            $items = $this->prepareModelQuery();
            $model = $items->find($id);
        }

        if(in_array('edit', $this->authorize)) {
            $this->authorize('update', $model);
        }
       
        return view($this::$bladePath . '.edit', $this->prepareViewData())->withModel($model);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        

        $qry = $this->prepareModelQuery();
        $model = $qry->find($id);

        // $validatedData = $request->validate(
        //     $this->rules($request, $model)
        // );

       

        Validator::make($request->all(), 
                    $this->rules($request, $model),
                    $this->messages($request, $model)
                    )->validate();


        // look out for arrays which should be JSON
        // foreach($request->all() as $key=>$tmp) {
        //     if (is_array($request->$key) && substr($key, 0, 1) != "_") {
        //         $request->merge([$key => json_encode($request->$key)]);
        //     }
        // }

        // aaargh - this breaks everywhere that a legitimate array is passed in.
        
        $this->commitModel($request, $model);
        return redirect()->to($request->_postsave);

    }


    /* implement this method to specify input validation rules to be applied before attempting to commit the model to the database */
    public function rules(Request $request, $model=null) {

        try {
            $cls = $this::$modelClass;
            return $cls::$rules;
        } catch (\Error $e) {

            // no rules - at the very least, ensure all non-nullable cols have values?
            // - but only deal with fields set in the post? 
            //  - i.e. - id and slug may be required, but not controlled on the form. Returning a validation failure will redisplay the form with no visible errors.

            $cls = $this::$modelClass;
            $inst = new $cls();

            $data = $request->all();

            $cols = \DB::connection()
            ->getDoctrineSchemaManager()
            ->listTableColumns($inst->getTable());

            $rules = [];
            foreach($cols as $key=>$col) {
                if (array_key_exists($key, $data) && $col->getNotNull()) {
                    $rules[$key] = 'required';
                }
            }
     
            return $rules;

        }
  
    }

     /* override this method to specify custom validation messages for the above rules */
    public function messages(Request $request, $model=null):array {
        return []; //
    }


    /* implement this method with the code which reads data from the request into the Model and commits it to the database */
    public function commitModel(Request $request, Model $model) {
        
        // this *Should* be all that's needed.
        // can be overridden for any custom processing. 
        // But, the Extender HasX traits should be handling their data in all this.
        $model->fill($request->all());

        // dd($model);

        $model->save();

    }

    

    /**
     * Confirms the deletion action
     * (Doesn't actually do it...)
     */
    public function delete($id=null) {

        if ($this->allowDeletions) {

            $cls = $this::$modelClass;
            
            if (is_null($id)) {
                $model = new $cls();
            } else {
                $qry = $this->prepareModelQuery();
                $model = $qry->find($id);
            }


            if(in_array('delete', $this->authorize)) {
                try {
                    $this->authorize('delete', $model);
                } catch (\Exception $e) {
                    return view('cms::admin.modals.nodelete', $this->prepareViewData())->with('exception', $e); 
                }
             }

            return view('cms::admin.modals.confirmdelete', $this->prepareViewData())->withModel($model);

        } else {

            return view('cms::admin.modals.nodelete', $this->prepareViewData()); 

        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if($this->allowDeletions) {

            $cls = $this::$modelClass;
            
            if (is_null($id)) {
                $model = new $cls();
            } else {
                $qry = $this->prepareModelQuery();
                $model = $qry->find($id);
            }

            if($model) {
                $model->delete();
            }

        }
        
       
        return redirect(url()->previous());
       
    
    }



}
