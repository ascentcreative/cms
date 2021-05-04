<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Base
{
    use HasFactory;

    public $fillable = ['disk', 'filepath', 'orginalname', 'mimetype'];

    public $hidden = ['disk', 'filepath'];

}

