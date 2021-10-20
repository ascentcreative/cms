<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{

    public $type;
    public $label;
    public $name;
    public $value;

    public $accept;
    public $autocomplete;

    public $wrapper;
    public $class;

    public $multiple; // only used on file inputs


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $label, $name, $value, $accept="", $autocomplete=false, $wrapper="bootstrapformgroup", $class='', $multiple='false')
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;

        $this->accept = $accept;
        $this->autocomplete = $autocomplete;

        $this->wrapper = $wrapper;
        $this->class = $class;

        $this->multiple = $multiple;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.form.input');
    }
}
