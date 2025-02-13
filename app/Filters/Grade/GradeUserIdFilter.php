<?php

namespace App\Filters\Grade;

use App\Filters\Pipe;
use Closure;

class GradeUserIdFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('userId')){
            $content->where('user_id', request()->get('userId'));
        }
        return $next($content);
    }
}
