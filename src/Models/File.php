<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class File extends Base
{
    use HasFactory;

    public $fillable = ['disk', 'filepath', 'original_name', 'mimetype'];

    public $hidden = ['disk', 'filepath'];


    public function getFullpathAttribute() {

        return Storage::disk($this->disk)->path($this->filepath);

    }

    public function download() {
        return Storage::disk($this->disk)->download($this->filepath, $this->original_name);
    }


}

