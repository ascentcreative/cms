<?php

namespace AscentCreative\CMS\Traits;

use AscentCreative\CMS\Traits\Extender;
use AscentCreative\CMS\Models\HeaderImage;

use Illuminate\Http\Request;

trait HasHeaderImage {

    use Extender;


    public function initializeHasHeaderImage() {
        $this->fillable[] = '_headerimage';//  echo 'BOOTING!';
    }

    /* define the relationship */
    public function headerimage() {
        return $this->morphOne(HeaderImage::class, 'headerable');
    }


    public function captureHeaderImage($key) {

        session([$key . '._headerimage' => $this->_headerimage]);

        unset($this->attributes['_headerimage']);

    }

    public function saveHeaderImage($key) {
        
        $data = session()->pull($key . '._headerimage');

        if(!is_null($data)) {
            $this->headerimage()->updateOrCreate([], $data);
        }

    }



}
