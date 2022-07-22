<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Admin\UI\Index\Column;

class UserController extends AdminBaseController
{

    static $modelClass = 'App\Models\User';
    //static $modelClass = 'AscentCreative\CMS\Models\User';
    static $bladePath = "cms::admin.users";
    static $formClass = 'AscentCreative\CMS\Forms\Admin\User';

    public $indexSearchFields = ['first_name', 'last_name', 'email'];


    public function commitModel(Request $request, Model $model) {

        // Save the Cheerleader (User)
        parent::commitModel($request, $model); 

        // Save the World (Permissions & Roles)
        print_r($request->roles);

        $model->syncRoles($request->roles);
        $model->syncPermissions($request->permissions);

    }



    public function rules($request, $model=null) {

       return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email'
        ]; 

    }


    public function autocomplete(Request $request) { //Request $request, string $term) {

        // Should this be encapsulated in a 'search' method on the model?
        //  - would allow all search formats to always use the same fields. Handy for the index filters. 
        $term = $request->term;
        $cls = $this::$modelClass;
        $data = $cls::where('last_name', 'like', '%' . $term . '%')
                        ->orWhere('first_name', 'like', '%' . $term , '%')
                        ->orWhere(DB::Raw('concat(first_name, " ", last_name)'),  'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%')->get();

        // Can't easily concat fields etc without making a raw query
        // Not keen on that for security, so we'll loop and assign the label here.
        // Plus, we get the benefit of using the model accessor.
        foreach($data as $row) {
            $row['label'] = $row->nameAndEmail; // . ' (' . $row->email . ')';
        }

        return $data;

    }


    public function getColumns() : array {

        return [

            Column::make('Name')
                ->valueProperty('name')
                ->isLink(true),

            Column::make('Email')
                ->value(function($item) {
                    return obscure($item->email);
                }),

            Column::make('Roles')
                ->value(function($item) {
                    return join(', ', $item->getRoleNames()->toArray() ?? []);
                }),

            Column::make('Permissions')
                ->value(function($item) {
                    return join(', ', $item->getPermissionNames()->toArray() ?? []);
                }),

            Column::make("Last Login")
                ->valueProperty('lastLogin'),


        ];

    }



}