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

    public function setSlug($force=false) {

        $source = $this->slug_source ?? 'title';
        $target = $this->slug_field ?? 'slug';

        if ($force || (!isset($this->attributes[$target]) || $this->attributes[$target]==='')) {

            $slug = Str::slug(($this->$source), '-');
    
            // check to see if any other slugs exist that are the same & count them
            $query = static::withoutGlobalScopes()
                        ->whereRaw("$target RLIKE '^{$slug}(-[0-9]+)?$'");

            if($this->id) {
               $query->where('id', '<', $this->id);
            }
            $count = $query->count();
    
            $this->attributes[$target] = $count ? "{$slug}-{$count}" : $slug;

        }

    }

}
