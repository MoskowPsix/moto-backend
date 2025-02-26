<?php

namespace App\Filters\Command;

use App\Filters\Pipe;
use Closure;

class NameCommandFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('name')){
            $content->where('name', 'ilike', request()->get('userId'));
        }
        return $next($content);
    }
}
