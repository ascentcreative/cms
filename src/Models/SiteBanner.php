<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Str;


class SiteBanner extends Base
{
    use HasFactory;

    public $table = "cms_sitebanners";
    public $fillable = ['title', 'text', 'link_url', 'image_id', 'bgcolor', 'publishable', 'start_date', 'end_date'];

 
    public function scopeLive($query) {
        
        $query->where('publishable', '1');

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


}

