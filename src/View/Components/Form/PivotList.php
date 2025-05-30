<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class PivotList extends Component
{

    public $label;
    public $name;
    public $value;

    public $dataval;

    public $optionRoute;
    public $labelField;
    public $addToAll;
    public $sortField;
    public $pivotField;
    public $pivotFieldLabel;
    public $pivotFieldPlaceholder;

    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $value, $optionRoute, $optionModel, $labelField, 
                                $addToAll=null, $sortField=null, 
                                $pivotField=null, $pivotFieldLabel=null, $pivotFieldPlaceholder=null,
                                $class="")
    {
     
        /*
          The Label to display next to the component
          */
        $this->label = $label;

        /* 
        The field name (to match model property name)
        */
        $this->name = $name;
        
        /*
        The value to set the component with on form load
        */
        //$this->value = $value;


     
        
        /*
        The URL to which the type-ahead/automplete terms will be sent
        */
        $this->optionRoute = $optionRoute;

        /*
        The field from the autocomplete data to be used as the label for the individual elements
        */
        $this->labelField = $labelField;

        /*
        [OPTIONAL] 
        An array of fieldname=>value - this will be set on all items when the data is submitted.
        Useful where the pivot rows are classified by different types/roles
        */
        $this->addToAll = $addToAll;

        /*
        [OPTIONAL]
        The name of the pivot table field which controls the sort order of the elements. 
        Specifying this makes the list draggable/sortable. The indexes are written to this field and
        submitted to the server
        */
        $this->sortField = $sortField;

        /* 
        [OPTIONAL]
        The fieldname of a text field to add to the elements. Allows extra user input to be given. 
        The entered value will be written the field of this name in the pivot table.
        */
        $this->pivotField = $pivotField;

        /*
        [OPTIONAL]
        A text label for the above pivotField
        */
        $this->pivotFieldLabel = $pivotFieldLabel;

        /*
        [OPTIONAL]
        Text to show in the pivotField when no value ahs been entered
        */
        $this->pivotFieldPlaceholder = $pivotFieldPlaceholder;

        // can something here fill in the missing display-only data?
        // i.e. if we tell the component which model it's displaying, and the label property
        // the code can fetch that on load. 
        // this will keep the transmitted data to a minimum and match the format required for the sync
        // 

        $this->optionModel = $optionModel;

      
          // format incoming value data
        
          if (is_object($value) && $value instanceof Collection) {

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

                $row = array();    
                $row['id'] = $idx;
                $row['label'] = $cls->$labelField;

                $data[] = $row;
            }

            $this->value = $data;

        } else {
            echo 'Unexpected Data Type';
        }


        $this->class = $class;
        
    }


    public function getDataAttribute() {

            return array(1,2,3);

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.form.pivotlist');
    }
}
