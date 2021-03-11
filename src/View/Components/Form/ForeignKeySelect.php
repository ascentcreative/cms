<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

/*
 *
 * Creates a SELECT element, populated from a specified DB table, with the selected ID as the value. 
 * Ideal for one-to-many liinkages.
 * 
 */
class ForeignKeySelect extends Component
{

    public $type;
    public $label;
    public $name;
    public $value;

  //  public $model;
    public $query;
    public $labelField;
    public $idField;
    

    public $wrapper;
    public $class;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $label, $name, $value, $query, $labelField="title", $idField="id", $wrapper='bootstrapformgroup', $class='')
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;

        // foreign model / table info:
          //  $this->model = $model;

            $this->query = $query; // Builder instance allowing filters to be applied to the dataset

            $this->labelField = $labelField;
            $this->idField = $idField;

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
        return view('cms::components.form.foreignkeyselect.' . $this->type);
    }
}
