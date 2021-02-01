<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class BibleRefList extends Component
{

    public $label;
    public $name;
    public $value;

    public $dataval;

    public $deuterocanonical;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $value, $deuterocanonical=false)
    {
     
        $this->value = $value;

        /*
          The Label to display next to the component
          */
        $this->label = $label;

        /* 
        The field name (to match model property name)
        */
        $this->name = $name;

        $this->deuterocanonical = $deuterocanonical;
        
       
       
          // format incoming value data
        
   /*     if (is_object($value) && $value instanceof Collection) {

                $data = array();
                foreach($value as $idx=>$itm) {
                    // id is the key for our array
                
                    $row = $itm->pivot;

                    $cls = $this->optionModel;
                    $lbl = $this->labelField;
                    $cls = $cls::find($itm->id);
                    
                    $row['id'] = $itm->id;
                    $row['label'] = $cls->$labelField;
                    
                    $data[] = $row;

                }
                
                $this->value = $data;


        } else if (is_array($value)) { 

            // incoming data is an array, so is in a different format 
            // to the Eloquent Collection above. Most likely from a validation 
            // failure elswhere on the form (i.e. formatted for Pivot Sync, rather than 
            // data from the query). 
  
            $data = array();
            foreach($value as $idx=>$row) {

                $cls = $this->optionModel;
                $lbl = $this->labelField;
                $cls = $cls::find($idx);
                    
                $row['id'] = $idx;
                $row['label'] = $cls->$labelField;

                $data[] = $row;
            }

            $this->value = $data;

        } else {
            echo 'Unexpected Data Type';
        } */
        
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.form.biblereflist');
    }
}
