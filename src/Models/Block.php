<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Str;


class Block extends Base
{
    use HasFactory;

    public $fillable = ['stack_id', 'blocktemplate_id', 'name', 'slug', 'data', 'sort', 'published', 'start_date', 'end_date'];

    public function stack() {
        return $this->belongsTo(Stack::class);
    }

    public function template() {
        return $this->belongsTo(BlockTemplate::class, 'blocktemplate_id');
    }

    public function setDataAttribute($data) {
        $this->attributes['data'] = json_encode($data);
    }

    public function scopeLive($query) {
        
        $query->where('published', '1');

        $query->where(function($q) {
            $q->whereNull('start_date')
                ->orWhereRaw('start_date < now()' );
        });

        $query->where(function($q) {
            $q->whereNull('end_date')
                ->orWhereRaw('end_date > now()' );
        });

        return $query;

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

