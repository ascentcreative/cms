<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

class PivotList extends Component
{

    public $type;
    public $label;
    public $name;
    public $value;
    public $labelField;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $label, $name, $value, $labelField)
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->labelField = $labelField;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.form.pivotlist');
    }
}
