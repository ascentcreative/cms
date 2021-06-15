<?php

namespace AscentCreative\CMS\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Str;


trait HasSlug {
    
    public static function bootHasSlug() {

        static::saving(function($model) { 

            $source = $model->slug_source ?? 'title';
            $target = $model->slug_field ?? 'slug';
            
            if (!isset($model->attributes[$target]) || $model->attributes[$target]==='') {
        
                $slug = Str::slug(($model->$source), '-');
        
                // check to see if any other slugs exist that are the same & count them
                $count = static::whereRaw("$target RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        
                $model->attributes[$target] = $count ? "{$slug}-{$count}" : $slug;
        
            }


        });
  
    }


}

