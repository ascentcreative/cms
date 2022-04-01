<?php

namespace AscentCreative\CMS\View\Components\MultiStepForm;

use Illuminate\View\Component;

class FormStep extends Component
{

    public $icon;
    public $label;

    public $validators;
    public $validatormessages;

    public $continueLabel;
    public $continueIcon;

    public $backLabel;
    public $backIcon;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $icon = '', $validators = [], $validatormessages = [], 
                                    $continueLabel="Continue", $continueIcon="bi-caret-right-fill",
                                    $backLabel="Back", $backIcon="bi-caret-left-fill"
                        )
    {
        //
        $this->label = $label;
        $this->icon = $icon;
        $this->validators = $validators;
        $this->validatormessages = $validatormessages;

        $this->continueLabel = $continueLabel;
        $this->continueIcon = $continueIcon;

        $this->backLabel = $backLabel;
        $this->backIcon = $backIcon;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.multi-step-form.step');
    }
}
