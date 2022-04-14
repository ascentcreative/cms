<?php
namespace AscentCreative\CMS\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{

    public $modalid;
    public $modalclass;
    public $title;
    public $closebutton;
    public $centered = false;
    public $size;

    public $modalShowHeader = true;
    public $modalShowFooter = true;

    public function __construct($modalid, $modalclass='', $title='', $closebutton=true, $centered=false, $showHeader=true, $showFooter=true, $size="modal-lg") {

       // dd($modalid);

        $this->modalid = $modalid;
        $this->modalclass = $modalclass;

        $this->title = $title;
        $this->closebutton = $closebutton;
        $this->centered = $centered;
        $this->modalShowHeader = $showHeader;
        $this->modalShowFooter = $showFooter;
        $this->size = $size;

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