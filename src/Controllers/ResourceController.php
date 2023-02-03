<?php
namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;



/**
 * A base class for Resource controllers (i.e. those configured using Route::resource)
 * 
 * Designed to be extended for specific models, eventualyl replacing the 'AdminBaseController' which did the same thing in an admin context.
 * Will use the new ascentcreative\filter package and aim to separate out the creation of views (via a viewbuilder class, rather than an overridden method)
 * 
 */
class ResourceController extends Controller {

    static $modelClass = 'DEFINE_ME';
    static $bladePath = 'define.me';
    static $formClass = null; //'DEFINE_ME';



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {



    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null) {

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=null) {


    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {


    }



     /**
     * Confirms the deletion action
     * (Doesn't actually do it...)
     */
    public function delete($id=null) {



    }




     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {


    }



}