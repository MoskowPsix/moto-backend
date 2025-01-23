<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;

class RaceUserIdFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('userId')){
            $content->where('user_id', request()->get('userId'));
        }
        return $next($content);
    }
}
