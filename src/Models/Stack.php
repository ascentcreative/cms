<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Stack extends Base
{
    use HasFactory;

    public $fillable = ['name', 'slug'];

    public function blocks() {
        return $this->hasMany(Block::class)->orderBy('sort');
    }

    public function liveblocks() {
        return $this->blocks()->live();
    }

    /*
     * MUTATORS
     * 
     * setTitleAttribute: takes the incoming title and sets the slug accordingly
     */
    public function setNameAttribute($value) {
        // set the title so the value doesn't get lost
        $this->attributes['name'] = $value;

        if (!isset($this->attributes['slug']) || $this->attributes['slug']==='') {
            
            $slug = Str::slug(($value), '-');

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $this->attributes['slug'] = $count ? "{$slug}-{$count}" : $slug;

        }

    }

}

