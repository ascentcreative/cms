<?php

namespace AscentCreative\CMS\Middleware;

use Closure;
use Illuminate\Http\Response;

class UseAdminLogin
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

}
