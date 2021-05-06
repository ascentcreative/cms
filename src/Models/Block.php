<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Block extends Base
{
    use HasFactory;

    public $fillable = ['stack_id', 'blocktemplate_id', 'name', 'data', 'sort', 'published', 'start_date', 'end_date'];

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

}

