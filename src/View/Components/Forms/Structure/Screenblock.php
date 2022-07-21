<?php

namespace AscentCreative\CMS\View\Components\Forms\Structure;

use Illuminate\View\Component;

class Screenblock extends Component
{

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::forms.structure.screenblock');
    }
}
