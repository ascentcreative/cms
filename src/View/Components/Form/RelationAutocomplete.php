<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

/*
 *
 * Creates a SELECT element, populated from a specified DB table, with the selected ID as the value. 
 * Ideal for one-to-many liinkages.
 * 
 */
class RelationAutocomplete extends Component
{

    // public $type;
    public $label;
    public $relationship;

    public $name;
    public $value;
    public $display;
    public $dataurl;

    public $placeholder;
    
    public $wrapper;
    public $class;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $relationship, $dataurl, $name=null, $displayField='title', $placeholder="Begin typing to search...", $wrapper='bootstrapformgroup', $class='')
    {
       
        $this->label = $label;
        $this->relationship = $relationship;
        $this->dataurl = $dataurl;

        if (is_null($name)) {
            $this->name = $relationship->getRelationName() . '_id';
        } else {
            $this->name = $name;
        }
        


        $related = $relationship->getRelated();

        if($old = old($this->name)) {

            // dd($old);
            $foreign = $related::find($old); //->first();
            // dd($foreign);
        } else {
            $foreign = $relationship->first();
        }


        // from the relation, build up the data...

        // get the foreign model
        
       

        if($foreign) {
            $this->value = $foreign->id;
            $this->display = $foreign->$displayField;
        }
       // dd($relationship);
        $this->placeholder = $placeholder;

    
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
        return view('cms::components.form.relationautocomplete');
    }
}
