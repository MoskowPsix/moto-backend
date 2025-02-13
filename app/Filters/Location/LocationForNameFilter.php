<?php

namespace App\Filters\Location;

use App\Filters\Pipe;
use Closure;
class LocationForNameFilter implements Pipe
{

    public function apply($content, Closure $next)
    {
        if(request()->has('name')){
            $content->where('name', 'ilike', '%'.request()->get('name').'%');
        }
        return $next($content);
    }
}
