<?php

namespace AscentCreative\CMS\Models;


use AscentCreative\CMS\Traits\HasHeaderImage;
use AscentCreative\CMS\Traits\HasImages;
use AscentCreative\CMS\Traits\HasMenuItem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;


/**
 * Used a convenient jumping off point for all models in the package.
 * Essentially just prefixes all child models' table names with 'checkout_'. 
 */
class Page extends Base
{
    use HasFactory, HasImages, HasMenuItem; //HasHeaderImage; 

    public $fillable = ['title', 'content'];
    
    /*
     * MUTATORS
     * 
     * setTitleAttribute: takes the incoming title and sets the slug accordingly
     */
    public function setTitleAttribute($value) {
        // set the title so the value doesn't get lost
        $this->attributes['title'] = $value;

        if (!isset($this->attributes['slug']) || $this->attributes['slug']==='') {
            
            $slug = Str::slug(($value), '-');

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $this->attributes['slug'] = $count ? "{$slug}-{$count}" : $slug;

        }

    }

    public function getUrlAttribute() {
        return '/' . $this->slug;
    }

}
