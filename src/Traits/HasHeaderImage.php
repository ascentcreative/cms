<?php

namespace AscentCreative\CMS\Traits;

use AscentCreative\CMS\Traits\Extender;
use AscentCreative\CMS\Models\HeaderImage;

use Illuminate\Http\Request;

trait HasHeaderImage {

    use Extender;

    
    public static function bootHasHeaderImage() {
  
        static::deleted(function ($model) {
          $model->deleteHeaderImage();
        });
  
        static::saving(function($model) { 
          $model->captureHeaderImage();
        });
  
        static::saved(function($model) { 
          $model->saveHeaderImage();
        });
  
      }


    public function initializeHasHeaderImage() {
        $this->fillable[] = '_headerimage';//  echo 'BOOTING!';
    }

    /* define the relationship */
    public function headerimage() {
        return $this->morphOne(HeaderImage::class, 'headerable');
    }


    public function captureHeaderImage() {

        session(['extenders._headerimage' => $this->_headerimage]);

        unset($this->attributes['_headerimage']);

    }

    public function saveHeaderImage() {
        
        $data = session()->pull('extenders._headerimage');

        if(!is_null($data)) {
            $this->headerimage()->updateOrCreate([], $data);
        }

    }



}
