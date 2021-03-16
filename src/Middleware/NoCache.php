<?php

namespace AscentCreative\CMS\Middleware;

use Closure;
use Illuminate\Http\Response;

class NoCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $this->processResponse($response);
    }


    public function processResponse($response) {

        return $response->header("Cache-Control","no-cache, no-store, must-revalidate")
                        ->header("Pragma", "no-cache")
                        ->header("Expires", "0");


    }


}
