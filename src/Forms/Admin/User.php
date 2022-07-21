<?php
namespace AscentCreative\CMS\Forms\Admin;

use AscentCreative\CMS\Forms\Admin\BaseForm;
use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\ForeignKeySelect;
use AscentCreative\CMS\Forms\Structure\Screenblock;

class User extends BaseForm {

    public function __construct() {

        parent::__construct();

        $this->children([

            Screenblock::make('details')
                ->children([
                    Input::make('first_name', 'First Name')
                            ->description('The first name of the user')
                            ->default('123')
                            ->required(true),

                    Input::make('last_name', 'Last Name')
                            ->description('The last name of the user')
                            ->required(true), 

                    Input::make('email', 'Email')
                            ->description('Their email address (also used for logging in etc)')
                            ->rules(['required', 'email'])

                ]),

            Screenblock::make('permissions_block')
                ->children([
                    ForeignKeySelect::make('roles', "Roles", 'checkbox')
                            ->description('Be careful editing this value if this is your own record. You may lock yourself out...')
                            ->query(\Spatie\Permission\Models\Role::query())
                            ->labelField("name")
                            ->idField('name'),

                    ForeignKeySelect::make('permissions', "Permissions", 'checkbox')
                            ->description('Be careful editing this value if this is your own record. You may lock yourself out...')
                            ->query(\Spatie\Permission\Models\Permission::query())
                            ->labelField("name")
                            ->idField('name'),
                ]),

        ]);

        $elm = $this->getElement('email');
        $elm->required(true);

    }

}
