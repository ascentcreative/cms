<?php

namespace AscentCreative\CMS\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

use AscentCreative\CMS\Traits\Extender;

/**
 * Reusable trait to specifiy publishing properties for a model
 * 
 *  - Publishable (if true, model 'can' be seen - or rather, if false CANNOT be seen. If true, maybe be affacted by the dates )
 *  - PublishStartDate (The date the model becomes live - Publishable must be true. Null = immediate)
 *  - PublishEndDate  (The date the model will go offline - Null = indefinite)
 * 
 *  - "Published" scope - takes the above into account and returns only currently published items
 * 
 */

trait Publishable {

    use Extender;

    public static function bootPublishable() {

        // apply a global scope which automatically wires in the publishing settings
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('publishable', '=', '1') 
                    ->where(function($query) { 
                        $query->whereDate('publish_start', '<', date('Y-m-d H:i:s'))
                            ->orWhereNull('publish_start');
                    })
                    ->where(function($query) { 
                        $query->whereDate('publish_end', '>=', date('Y-m-d H:i:s'))
                            ->orWhereNull('publish_end');
                    });
        });


        // when the model is being saved, migrate the field data...
        // (this shoudln't be needed here - I need to find a way to wire this up to the field components)
        static::saving(function($model) { 

            if($model->publish_start['date'] == '') {
                $model->publish_start = null;
            } else {
                $model->publish_start = join(' ', $model->publish_start);// . ":00";
            }

            if($model->publish_end['date'] == '') {
                $model->publish_end = null;
            } else {
                $model->publish_end = join(' ', $model->publish_end);// . ":00";
            }

            //dd($model);

        });

    }
    
    public function initializePublishable() {

        // add fields to fillable:
        $this->fillable = array_merge($this->fillable, ['publishable', 'publish_start', 'publish_end']);

    }



}

