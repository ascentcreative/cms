<?php

namespace AscentCreative\CMS\View\Components;

use Illuminate\View\Component;

class MultiStepForm extends Component
{

    public $progress;
    public $action;
    public $method;
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action=null, $method='POST', $id='')
    {
        //
        $this->action = $action ?? url()->current(); 
        $this->method = $method;
        $this->id = $id;
       

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.multi-step-form.base');
    }
}
