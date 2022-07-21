<?php
namespace AscentCreative\CMS\Forms\Admin;

use AscentCreative\Forms\Form;
use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\ForeignKeySelect;
use AscentCreative\CMS\Forms\Structure\Screenblock;

class BaseForm extends Form {

    public function __construct() {

        $this->children([
            Input::make('_postsave', null, 'hidden')
                    ->value(old('_postsave', session('last_index')))
                    ->wrapper('none'),
        ]);

    }

}
