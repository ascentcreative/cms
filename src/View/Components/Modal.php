<?php
namespace AscentCreative\CMS\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{

    public $modalid;
    public $title;
    public $closebutton;
    public $centered = false;

    public function __construct($modalid, $title='', $closebutton=true, $centered=false) {

       // dd($modalid);

        $this->modalid = $modalid;

        $this->title = $title;
        $this->closebutton = $closebutton;
        $this->centered = $centered;

    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.modal');
    }

}