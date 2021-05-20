<?php

namespace AscentCreative\CMS\Traits;

use AscentCreative\CMS\Traits\Extender;
use AscentCreative\CMS\Models\Image;
use AscentCreative\CMS\Models\ImageSpec;


use Illuminate\Http\Request;

/**
 * Experimental trait to try to allow multiple copies of the same trait partials
 * Use Case:
 *  - A model may have various images attached
 *  - Images will adhere to a spec (header: 1200x600, thumbnail - lo res, profile: 300x300 etc)
 *  - Ideally, the images would be spread around the model's form
 *  - We don't want to create a new Trait for each spec type - these should be held in the database and by dynamic as needed (set in model array at worst)
 * 
 *  - So... we use an 'image_specs' array on the model to define the images the model asks for
 *  - This will create an _images['spec'][...] data structure for the model to extract (essentially getting an array by spec name)
 * 
 *   - The Extender -> getTraitBlades will need to be updated. 
 *       - the trait itself will need to return the blades to use
 *       - These will need to be keyed by trait & subkey to allow them to be fetched independently and placed at will
 *       - (Worst case scenario, all the image fields are put on a single tab... but woudl like to avoid that...)
 * 
 */

trait HasImages {

    use Extender;

    
    public static function bootHasImages() {
  
        static::deleted(function ($model) {
          $model->deleteImages();
        });
  
        static::saving(function($model) { 
            if(request()->has('_images')) {
                $model->captureImages();
            }
        });
  
        static::saved(function($model) { 
            if(request()->has('_images')) {
                $model->saveImages();
            }
        });
  
      }


    public function initializeHasImages() {
        $this->fillable[] = '_images';//  echo 'BOOTING!';
    }

    /* define the relationship */
    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function imageBySpec($specName) {
        $spec = ImageSpec::where('slug', $specName)->first();

        if ($this->images()) {
            return $this->images()->where('image_spec_id', $spec->id)->first();
        }
      
    }

    public function imageSpecs() {
        return $this->morphToMany(\AscentCreative\CMS\Models\ImageSpec::class, 'imageable', 'cms_images');
    }


    public function captureImages() {

        if(!is_null($this->_images)) {

            session(['extenders._images' => $this->_images]);

            unset($this->attributes['_images']);

        }

    }

    public function saveImages() {

        $data = session()->pull('extenders._images');
      
        if(!is_null($data)) {

            $ary = array();

            foreach($data as $specSlug=>$image) {

                $spec = ImageSpec::where('slug', $specSlug)->first();

                $ary[$spec->id] = $image;
                //$ary[]

            }

            $this->imageSpecs()->sync($ary);
        }

    }


    protected function deleteImages() {
        
        $images = $this->images->all();

      // dd($images);

        foreach($images as $img) {
            if (!is_null($img)) {
                $img->delete();
            }
        }
        
    }


}
