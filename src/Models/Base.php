<?php

namespace AscentCreative\CMS\Models;

use AscentCreative\CMS\Traits\HasExtenders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;


/**
 * Used a convenient jumping off point for all models in the package.
 * Essentially just prefixes all child models' table names with 'checkout_'. 
 */
class Base extends Model
{
    use HasFactory;

    public function getTable()
    {
        return ($this->table ?? 'cms_' . Str::snake(Str::pluralStudly(class_basename($this))));
    }

}
