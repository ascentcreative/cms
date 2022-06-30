<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

class CompoundDate extends Component
{

    public $label;
    public $name;
    public $value;
    public $orig;
    
    public $wrapper;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $value, $wrapper="bootstrapformgroup", $class='')
    {
     
        $this->orig = $value;

        // parse incoming value...
        if(!is_null($value) && $value != '' && $value != "0000-00-00") {
            $cbn = new \Carbon\Carbon($value);
            // dd($cbn);
            $this->value['day'] = date_format($cbn, 'd');
            $this->value['month'] = date_format($cbn, 'm');
            $this->value['year'] = date_format($cbn, 'Y');
        }


        $this->label = $label;
        $this->name = $name;
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
        return view('cms::components.form.compound-date');
    }
}
