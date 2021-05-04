<?php

namespace AscentCreative\CMS\View\Components\Form;

use Illuminate\View\Component;

class FileUpload extends Component
{

    
    public $label;
    public $name;
    public $value;

    public $disk;
    public $path;
    public $preserveFilename;
    public $wrapper;
    public $class;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $value, $disk='public', $path='ajaxuploads', $preserveFilename=false, $wrapper="bootstrapformgroup", $class='')
    {
        
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;

        $this->preserveFilename = $preserveFilename;
        $this->disk = $disk;
        $this->path = $path; 
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
        return view('cms::components.form.fileupload');
    }
}
