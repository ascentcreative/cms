<?php

namespace AscentCreative\CMS\Middleware;

use Closure;
use Illuminate\Http\Response;

class Tokenise
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $this->processResponse($response);
    }


    public function processResponse($response) {


        $content = $response->getContent();

        // if (strstr($content, '[[ REPLACEME ]]') !== false) {

        //     $content = str_replace('[[ REPLACEME ]]', view('cms::test.insertblade'), $content);

        // }

        // return $response->setContent($content);

        $ary = $response->getOriginalContent();

        print_r($ary->model);

        //print_r(token_get_all($content));
        exit();


    }


}
