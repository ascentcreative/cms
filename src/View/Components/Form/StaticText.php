<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

class StaticText extends Component
{

   
    public $label;

    public $wrapper;
    public $class;

    public $name;

   
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $wrapper="bootstrapformgroup", $class='')
    {
        $this->label = $label;

        $this->wrapper = $wrapper;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.form.statictext');
    }
}
