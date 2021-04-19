<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

/*
 *
 * Creates a SELECT element, populated from a specified DB table, with the selected ID as the value. 
 * Ideal for one-to-many liinkages.
 * 
 */
class BlockSelect extends Component
{

    public $label;
    public $name;
    public $value;

    public $columns;
    public $options;
    public $maxSelect;
    public $maxHeight;
  //

    public $wrapper;
    public $class;

    public $blockblade;

    public $optionLabelField;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $value, $options, $columns=2, $maxSelect=-1, $maxHeight=null, $optionLabelField='', $blockblade='', $wrapper='bootstrapformgroup', $class='')
    {

        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;

        $this->columns = $columns;
        $this->maxSelect = $maxSelect;
        $this->maxHeight = $maxHeight;

        $this->wrapper = $wrapper;
        $this->class = $class;
        $this->blockblade = $blockblade;

        $this->optionLabelField = $optionLabelField;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.form.blockselect');
    }
}
