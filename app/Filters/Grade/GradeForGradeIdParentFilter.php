<?php

namespace App\Filters\Grade;

use App\Filters\Pipe;
use Closure;

class GradeForGradeIdParentFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('gradeNotParent')){
            $content->whereNull('grade_id');
        }
        return $next($content);
    }
}
