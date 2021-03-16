<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
 
use Illuminate\Database\Eloquent\Model;

abstract class AdminBaseController extends Controller
{

    static $modelClass = 'DEFINE_ME';
    static $bladePath = 'define.me';

    public $modelName = null; // override if the class name doesn't parse nicely.
    public $modelPlural = null; // override this if the auto-plural fails spectacularly...

    public $pageSize = 15;
    public $indexSort = array();
    public $indexSearchFields = array();

    /**
     * Creates an array of the generic data points used by the view
     * (i.e. model name, plural, etc)
     */
    public function prepareViewData() {

        $short = (new \ReflectionClass($this::$modelClass))->getShortName();

        $modelName = $short ?? $this->modelName;

        $modelNameHuman = join(' ', preg_split('/(?=[A-Z])/',$modelName));

        return array(
            'modelInject' => Str::lower($modelName),
            'modelName' => $modelNameHuman,
            'modelPlural' => (Str::pluralStudly($modelNameHuman) ?? $this->modelPlural)
        );

    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // get the items for the view
        $items = ($this::$modelClass)::query();
        
        // prepare any defined filters...

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
       
        // prepare any defined sorters...

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
        
        $items = $items->paginate($this->pageSize)->withQueryString();

        return view($this::$bladePath . '.index', $this->prepareViewData())->with('models', $items);
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

        $validatedData = $request->validate(
            $this->rules($request)
        );

        $cls = $this::$modelClass;
        $model = new $cls();
        $this->commitModel($request, $model);
        return redirect()->to($request->_postsave);
  
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo 'here';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=null)
    {
        $cls = $this::$modelClass;
        
        if (is_null($id)) {
            $model = new $cls();
        } else {
            $model = $cls::find($id);
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

        $cls = $this::$modelClass;
        $model = $cls::find($id);

        $validatedData = $request->validate(
            $this->rules($request, $model)
        );
        
        $this->commitModel($request, $model);
        return redirect()->to($request->_postsave);

    }


    /* implement tthis method to specify input validation rules to be applied before attempting to commit the model to the database */
    public abstract function rules(Request $request, $model);


    /* implement this method with the code which reads data from the request into the Model and commits it to the database */
    public function commitModel(Request $request, Model $model) {
        
        // this *Should* be all that's needed.
        // can be overridden for any custom processing. 
        // But, the Extender HasX traits should be handling their data in all this.
        $model->fill($request->all());
        $model->save();

    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}
