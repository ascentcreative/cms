<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

/*
 *
 * Creates a SELECT element, populated from a specified DB table, with the selected ID as the value. 
 * Ideal for one-to-many liinkages.
 * 
 */
class RelatedTokens extends Component
{

    public $label;
    public $name;
    public $value;

    public $relationship;
  

    public $wrapper;
    public $class;

  


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $value=[], $relationship,
                            $wrapper='bootstrapformgroup', $class='')
    {

        $this->label = $label;
        $this->name = $name;
        
        $this->value = $value;
        
        $this->relationship = $relationship;

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
        return view('cms::components.form.relatedtokens');
    }
}
