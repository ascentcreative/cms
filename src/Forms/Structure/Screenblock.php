<?php
namespace AscentCreative\CMS\Forms\Structure;

use AscentCreative\Forms\Traits\Structural;
use AscentCreative\Forms\Contracts\FormComponent;
use AscentCreative\Forms\FormObjectBase;
use Illuminate\View\ComponentAttributeBag;

class Screenblock extends FormObjectBase implements FormComponent {

    use Structural;

    public $component = 'cms-forms-structure-screenblock';

    // static function make(...$args) {
    //     $cls = get_called_class();
    //     return new $cls(...$args);
    // }


    // public function buildAttributes() {
    //     return new ComponentAttributeBag([
    //         'children'=>$this->children,
    //     ]);
    // }

}