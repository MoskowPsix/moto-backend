<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;


class RaceForLocationIdsFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('LocationIds')){
            $content->whereIn('location_id', request()->get('LocationIds'));
        }
        return $next($content);
    }
}
