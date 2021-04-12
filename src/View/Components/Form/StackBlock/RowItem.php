<?php

namespace AscentCreative\CMS\View\Components\Form\StackBlock;

use Illuminate\View\Component;

class RowItem extends Component
{

   
  //  public $label;
 //   public $type;
    public $name;
    public $value;
    public $type;
  
  //  public $wrapper;
  //  public $class;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $name, $value)
    {
       
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::stack.block.row.item');
    }
}
