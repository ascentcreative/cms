<?php

namespace AscentCreative\CMS\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class CookieType extends Base
{
    use HasFactory;

    public $table = 'cms_cookietypes';
    public $fillable = ['title', 'description', 'sort', 'mandatory'];
    

}
