<?php

namespace AscentCreative\CMS\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

             if (array_search('useAdminLogin', $request->route()->gatherMiddleware()) !== false) {
                return route('admin-login');
            } else {
                return route('login');
            }

        }
    }
}
