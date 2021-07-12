<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

/*
 *
 * Menu Position & Context Element
 * 
 */
class NestedSet extends Component
{

    public $label;
    public $name;
    
    public $nullScopeLabel;

    public $scopeFieldName;
    public $relationshipFieldName;
    public $relationFieldName;

    public $scopeData; // JSON object of the scope values
    public $scopeKey; // The field name in the set elements which links them to the scopes
    public $nestedSetData;   // JSON object of the set heirarchy

    public $scopeValue;
    public $relationshipValue;
    public $relationValue;
    public $relationLabel;

    public $wrapper;
    public $class;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name,  

            $scopeFieldName,
            $relationshipFieldName,
            $relationFieldName,

            

            $scopeData,
            $scopeKey,
            $nestedSetData,

            $scopeValue,
            $relationshipValue,
            $relationValue,
            $relationLabel='title',

            $nullScopeLabel="Please Select:",

            $wrapper='bootstrapformgroup', $class='')
    {

        $this->label = $label;
        $this->name = $name;
        // $this->contextType = $contextType;
        // $this->contextId = $contextId;


        $this->scopeFieldName = $scopeFieldName;
        $this->relationshipFieldName = $relationshipFieldName;
        $this->relationFieldName = $relationFieldName;

        $this->scopeData = $scopeData;
        $this->scopeKey = $scopeKey;
        $this->nestedSetData = $nestedSetData;

        $this->scopeValue = $scopeValue;
        $this->relationshipValue = $relationshipValue;
        $this->relationValue = $relationValue;
        $this->relationLabel = $relationLabel;

        $this->nullScopeLabel = $nullScopeLabel;

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
        return view('cms::components.form.nestedset');
    }
}
