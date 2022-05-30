<?php

namespace AscentCreative\CMS\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Traits\HasSlug;

use Illuminate\Support\Str;


class SavedFilter extends Base
{
    use HasFactory, HasSlug; 

    public $table = 'cms_savedfilters';

    public $fillable = ['name', 'user_id', 'url', 'filter', 'is_global', 'is_default'];

    public $slug_source = 'name';

    protected static function booted()
    {
      
        // unlink relationships on delete
        static::saving(function ($model) {
            //$model->themes()->detach();
            $model->user_id = auth()->user()->id;

            $urlinfo = parse_url(url()->previous());
            $model->url = $urlinfo['path'];

            if(isset($urlinfo['query'])) {
                parse_str($urlinfo['query'], $query);

                unset($query['page']);

                $model->filter = http_build_query($query);
            }

        });
        
    }


    public function scopeByUrl($q, $url) {
        return $q->where('url', $url);
    }

    public function scopeGlobal($q) {
        return $q->where('is_global', 1);
    }

    public function scopePrivate($q) {
        return $q->where('is_global', 0);
    }


}
