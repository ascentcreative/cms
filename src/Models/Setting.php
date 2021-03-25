<?php

namespace AscentCreative\CMS\Models;


use AscentCreative\CMS\Traits\HasHeaderImage;
use AscentCreative\CMS\Traits\HasMenuItem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;


/**
 * Used a convenient jumping off point for all models in the package.
 * Essentially just prefixes all child models' table names with 'checkout_'. 
 */
class Setting extends Base
{
    use HasFactory;

    public $fillable = ['name', 'value'];
  

}
