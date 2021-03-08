<?php

namespace AscentCreative\CMS\Middleware;

use Closure;
use Illuminate\Http\Response;

class InsertBlade
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $this->processResponse($response);
    }


    public function processResponse($response) {


        $content = $response->getContent();

        if (strstr($content, '[[ REPLACEME ]]') !== false) {

            $content = str_replace('[[ REPLACEME ]]', view('cms::test.insertblade'), $content);

        }

        return $response->setContent($content);


    }


}
