<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

class CKEditor extends Component
{

    public $type;
    public $label;
    public $name;
    public $value;
    public $height;

    public $wrapper;
    public $class;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $label, $name, $value, $height=400,
                        $wrapper='bootstrapformgroup', $class=''        
                    )
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->height = $height;

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
        return view('cms::components.form.ckeditor');
    }
}
