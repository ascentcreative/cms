<?php

namespace AscentCreative\CMS\Traits;

use AscentCreative\CMS\Traits\BaseTrait;
use AscentCreative\CMS\Models\Metadata;

use Illuminate\Http\Request;

trait HasMetadata {

    use Extender;

    public static function bootHasMetadata() {
  
      static::deleted(function ($model) {
        $model->deleteMetadata();
      });

      static::saving(function($model) { 
            if(request()->has('_metadata')) {
                $model->captureMetadata();
            }
      });

      static::saved(function($model) { 
        if(request()->has('_metadata')) {
            $model->saveMetadata();
          }
      });

    }

    public function initializeHasMetadata() {
        $this->fillable[] = '_metadata';
    }

    /* define the relationship */
    public function metadata() {

        return $this->morphOne(Metadata::class, 'content');

    }


    public function captureMetadata() {

        session(['extenders._metadata' => $this->_metadata]);
        unset($this->attributes['_metadata']);     
       
    }

    

    public function saveMetadata() {
        
     
        $data = session()->pull('extenders._metadata');

        if(!is_null($data)) {
            $md = $this->metadata()->updateOrCreate([], ['keywords'=>$data['keywords'], 'description'=>$data['description']] );
            $md->save();
        }
        
       

    }


    protected function deleteMetadata() {
        
        $item = $this->metadata;

        if (!is_null($item)) {
            $item->delete();
        }
        
    }



    /** accessors: */

    public function getMetaDescriptionAttribute() {
        
        return $this->metadata->description ?? $this->generateMetaDescription();

    }

    public function getMetaKeywordsAttribute() {
        
        return $this->metadata->keywords ?? $this->generateMetaKeywords();

    }

    /** Override these methods for custom / automated meta descriptions & keywords:  */
    public function generateMetaDescription() {
        return null;
    }

    public function generateMetaKeywords() {
        return null;
    }

    
    

}
