<?php
namespace AscentCreative\CMS\View\Components;

use Illuminate\View\Component;

class Toast extends Component
{

    public $id;
    public $class;
    public $title;
    public $duration;
    public $autohide;
    
    public function __construct($id='', $class='', $title='', $duration=2000, $autohide=true) {

        $this->id = $id;
        $this->class = $class;

        $this->title = $title;
        $this->duration = $duration;
        $this->autohide = $autohide;

    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.toast');
    }

}