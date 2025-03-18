<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;

class RaceSortFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('sortField') && request()->get('sort')) {
            $content->orderBy(request()->get('sortField'), request()->get('sort'));
        }
            return $next($content);
    }
}
