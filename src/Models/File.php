<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Mostafaznv\PhpXsendfile\Facades\PhpXsendfile;

class File extends Base
{
    use HasFactory;

    public $fillable = ['disk', 'filepath', 'original_name', 'mimetype'];

    public $hidden = ['disk', 'filepath'];

    protected static function booted()
    {

        // delete on-disk file
        static::deleted(function ($model) {

            //dd('deleting file');
            // $model->file()->delete();
            Storage::disk($model->disk)->delete($model->filepath);


        });

    }



    public function getFullpathAttribute() {

        return Storage::disk($this->disk)->path($this->filepath);

    }

    public function download() {

        if(env('X_LITESPEED') == 1) {
            return response()->xlitespeed(Storage::disk($this->disk)->path($this->filepath)); 
        }

        return Storage::disk($this->disk)->download($this->filepath, $this->original_name);

    }

    public function getMimetypeAttribute() {
        return mime_content_type($this->fullpath);
    }


}

