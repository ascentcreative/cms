<?php

namespace AscentCreative\CMS\Traits;

use AscentCreative\CMS\Traits\BaseTrait;
use AscentCreative\CMS\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait HasAttachments {

    use Extender;

    public static function bootHasAttachments() {
  
      static::deleted(function ($model) {
        $model->deleteAttachments();
      });

      static::saving(function($model) { 
            if(request()->has('_attachments')) {
                $model->captureAttachments();
            }
      });

      static::saved(function($model) { 
        if(request()->has('_attachments')) {
            $model->saveAttachments();
          }
      });

    }

    public function initializeHasAttachments() {
        $this->fillable[] = '_attachments';
    }

    /* define the relationship */
    public function attachments() {
        return $this->morphMany(\AscentCreative\CMS\Models\File::class, 'attachedto');
     }


    public function captureAttachments() {

        session(['extenders._attachments' => $this->_attachments]);
        unset($this->attributes['_attachments']);     
       
    }

    

    public function saveAttachments() {
        
     
        $data = session()->pull('extenders._attachments');

        $ids = array();
        if( !is_null($data) ) {
            $ids = Arr::pluck($data, 'id'); 
        }
        // - delete files for this model which aren't in the incoming data
        $this->attachments()->whereNotIn('id', $ids)->delete(); 
        // - save files which are (will consolidate existing and add new)
        $this->attachments()->saveMany(\AscentCreative\CMS\Models\File::whereIn('id', $ids)->get());




    }


    protected function deleteAttachments() {
        
        $items = $this->attachments;

        foreach($items as $item) {
            $item->delete();
        }
        
    }



 
    
    

}
