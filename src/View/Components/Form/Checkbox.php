<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{

    public $type;
    public $label;
    public $name;
    public $value;
    public $checkedValue;

    public $labelescape;
    public $wrapper;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $label, $name, $value, $labelescape=true, $checkedValue=1, $wrapper="bootstrapformgroup", $class='')
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->checkedValue = $checkedValue;

        $this->wrapper = $wrapper;
        $this->labelescape = $labelescape;
        $this->class = $class;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.form.checkbox');
    }
}
