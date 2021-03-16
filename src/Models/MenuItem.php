<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NestedSet;
use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Support\Str;


/**
 * Used a convenient jumping off point for all models in the package.
 * Essentially just prefixes all child models' table names with 'checkout_'. 
 */
class MenuItem extends Base
{
   
    use HasFactory, NodeTrait;

    public $fillable = ['menu_id'];

    protected function getScopeAttributes()
    {
        return [ 'menu_id' ];
    }


    public function getItemTitleAttribute() {
        if (is_null($this->title)) {
            return $this->linkable->title;
        } else {
            return $this->title;
        }
    }

    public function linkable() {
        return $this->morphTo();
    }

}
