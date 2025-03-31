<?php

namespace App\Filters\Command;

use App\Filters\Pipe;
use Closure;

class CommandForLocationIdFilter implements Pipe
{

    public function apply($content, Closure $next)
    {
        if(request()->get("locationId")) {
            $content->where("location_id", request()->get("locationId"));
        }
        return $next($content);
    }
}
