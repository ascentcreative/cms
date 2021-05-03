<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swatch extends Base
{
    use HasFactory;

    public $fillable = ['name', 'slug', 'hex'];

}

