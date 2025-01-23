<?php

namespace App\Filters\Track;

use App\Filters\Pipe;
use Closure;

class TrackUserIdFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('userId')){
            $content->where('user_id', request()->get('userId'));
        }
        return $next($content);
    }
}
