<?php

namespace AscentCreative\CMS\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Str;


trait HasSlug {

    
    public static function bootHasSlug() {

        static::saving(function($model) { 

                $model->setSlug();

        });
  
    }

    public function setSlug() {

        echo 'setting slug on ' . $this->name;

        $source = $this->slug_source ?? 'title';
        $target = $this->slug_field ?? 'slug';

        if (!isset($this->attributes[$target]) || $this->attributes[$target]==='') {

            $slug = Str::slug(($this->$source), '-');
    
            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("$target RLIKE '^{$slug}(-[0-9]+)?$'")->count();
    
            $this->attributes[$target] = $count ? "{$slug}-{$count}" : $slug;

        }

    }

}
