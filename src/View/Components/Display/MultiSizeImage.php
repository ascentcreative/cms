<?php

namespace AscentCreative\CMS\View\Components\Display;

use Illuminate\View\Component;

class MultiSizeImage extends Component
{

    public $src;
    public $alt;
    public $class;
    public $style;
    public $width;
    public $height;

    public $includeSizes;

    // these are populated from the files discovered on disk.
    public $srcset;
    public $sizes;

  
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src, $alt='', $class="", $style="", $width="", $height="", $includeSizes = true)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->style = $style;
        $this->class = $class;
        $this->width = $width;
        $this->height = $height;
        $this->includeSizes = $includeSizes;


        /** Dynamically calculate the sizes and srcset from the stored images 
         *  (Note - doesn't use the sizes from the config file in case they've changed since the files were created )
         */


       

       

        $arySizes = [];

        $srcset = [];
        $sizes = [];

        if($src) {

            $info = pathinfo($src);
    
            $globname = $_SERVER['DOCUMENT_ROOT'] . $info['dirname'] . '/' . $info['filename'] . '@*.' . $info['extension'];
        
            foreach(glob($globname) as $file) {
                $image_width = getimagesize($file)[0];
                $srcset[] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file) . ' ' . $image_width . 'w';
                $sizes[] = $image_width; 
            } 

            $sizelist = [];
            $lastsize = '';

            foreach(collect($sizes)->sortDesc()->toArray() as $size) {
                $sizelist[] = $lastsize . $size . 'px';
                $lastsize = "(max-width: " . $size . "px) ";
            }

            $this->srcset = join(', ', $srcset);

            if($includeSizes) {
                $this->sizes = join(', ', array_reverse($sizelist));
            }

        }

       
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('cms::components.display.multisizeimage');
    }
}
