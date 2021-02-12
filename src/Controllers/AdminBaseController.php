<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Database\Eloquent\Model;

abstract class AdminBaseController extends Controller
{

    static $modelClass = 'DEFINE_ME';
    static $bladePath = 'define.me';

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view($this::$bladePath . '.index');
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
       
        return view($this::$bladePath . '.edit')->withModel($model);

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
    public abstract function commitModel(Request $request, Model $model);

    

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
