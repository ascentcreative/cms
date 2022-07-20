<?php
namespace AscentCreative\CMS\Forms\Admin;

use AscentCreative\Forms\Form;
use AscentCreative\Forms\Fields\Input;
use AscentCreative\CMS\Forms\Structure\Screenblock;

class User extends Form {

    public function __construct() {

        $this->children([

            Screenblock::make()
                ->children([
                    Input::make('first_name', 'First Name')
                            ->description('The first name of the user')
                            ->required(true),

                    Input::make('last_name', 'Last Name')
                            ->description('The last name of the user')
                            ->required(true), 

                    Input::make('email', 'Email')
                            ->description('Their email address (also used for logging in etc)')
                            ->required(true)

                ]),

        ]);

    }

}