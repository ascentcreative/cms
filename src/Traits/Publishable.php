<?php

namespace AscentCreative\CMS\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use Carbon\Carbon;

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
        // TODO: This needs to play better with the admin area (i.e. not apply there at all so hidden items still connect where needed)
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

        // apply a global scope for sorting publishable objects:
        // order by publishable [put drafts first in admin], if(publish_start is not null, publish_start, created_at) DESC [sort by relevant dates]
        static::addGlobalScope('publish_sort', function (Builder $builder) {
            $table = $builder->getModel()->getTable();
            $builder->orderBy('publishable')
                    ->orderBy(DB::raw('if(' . $table . '.publish_start is not null, ' . $table . '.publish_start, ' . $table . '.created_at)'), 'DESC');
        });

    }



    /**
     * Publish dates are entered in split fields. Merge them
     * 
     * @return [type]
     */
    public function setPublishStartAttribute($val) {
        if(is_array($val)) {
            if(is_null($val['date'])) {
                $val = null;
            } else {
                $val = join(' ', $val);// . ":00";
            }
        } 
        $this->attributes['publish_start'] = $val;
    }

    
    /**
     * Publish dates are entered in split fields. Merge them
     * 
     * @return [type]
     */
    public function setPublishEndAttribute($val) {
        if(is_array($val)) {
            if(is_null($val['date'])) {
                $val = null;
            } else {
                $val = join(' ', $val);// . ":00";
            }
        } 
        $this->attributes['publish_end'] = $val;
    }

    
    public function initializePublishable() {

        // add fields to fillable:
        $this->fillable = array_merge($this->fillable, ['publishable', 'publish_start', 'publish_end']);

        $this->casts = array_merge($this->casts, [
            'publish_start' => 'datetime:Y-m-d H:i:s',
            'publish_end' => 'datetime:Y-m-d H:i:s',
        ]);

    }

    static $PUBLISHABLE_DRAFT = 'draft';
    static $PUBLISHABLE_LIVE = 'live';
    static $PUBLISHABLE_EXPIRED = 'expired';
    static $PUBLISHABLE_SCHEDULED = 'scheduled';

   
    public function getPublishStatusAttribute() {

        if ($this->publishable != 1) {
            return self::$PUBLISHABLE_DRAFT;
        }

        if (!is_null($this->publish_start) && $this->publish_start->gt(Carbon::now())) {
            return self::$PUBLISHABLE_SCHEDULED;
        }

        if (!is_null($this->publish_end) && $this->publish_end->lt(Carbon::now())) {
            return self::$PUBLISHABLE_EXPIRED;
        }
     

        return self::$PUBLISHABLE_LIVE;

    }

    public function getPublishStatusIconAttribute() {

        $color = '';
        switch ($this->publishStatus) {
            case self::$PUBLISHABLE_DRAFT:
                $icon = 'vector-pen';
                //$color = 'text-warning';
                break;

            case self::$PUBLISHABLE_EXPIRED:
                $icon = 'calendar-x-fill';
                $color = 'text-danger';
                break;

            case self::$PUBLISHABLE_LIVE:
                $icon = 'check-circle-fill';
                $color = 'text-success';
                break;

            case self::$PUBLISHABLE_SCHEDULED:
                $icon = 'clock-fill';
                break;

        }
        
        return '<i class="bi-' . $icon . ' ' . $color . '"></i>';

    }

    public function getIsPublishedAttribute() {

        if ($this->publishStatus == self::$PUBLISHABLE_LIVE) {
            return true;
        } else {
            return false;
        }

    }



}

