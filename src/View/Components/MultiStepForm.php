<?php

namespace AscentCreative\CMS\View\Components;

use Illuminate\View\Component;

class MultiStepForm extends Component
{

    public $progress;
    public $action;
    public $method;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $method='POST')
    {
        //
        $this->action = $action;
        $this->method = $method;
       

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
