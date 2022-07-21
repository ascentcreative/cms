<?php
namespace AscentCreative\CMS\Forms\Structure;

use AscentCreative\Forms\Traits\Structural;
use AscentCreative\Forms\Contracts\FormComponent;
use AscentCreative\Forms\FormObjectBase;
use Illuminate\View\ComponentAttributeBag;

class Screenblock extends FormObjectBase implements FormComponent {

    use Structural;

    public $component = 'cms-forms-structure-screenblock';

    public function __construct($name) {
        $this->name = $name;
    }

}