<?php

namespace AscentCreative\CMS\Facades;

use Illuminate\Support\Facades\Facade;

class UserController extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'user-controller';
    }
}