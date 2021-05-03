<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stack extends Base
{
    use HasFactory;

    public $fillable = ['name', 'slug'];

    public function blocks() {
        return $this->hasMany(Block::class)->orderBy('sort');
    }

}

