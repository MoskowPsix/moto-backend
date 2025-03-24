<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;
class FavoriteExistsFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('userIdExists') && request()->has('favouritesUser')){
            $userId = request()->get('userIdExists');
//            dd($content->first()->appointments()->get());
            $content->withExists(['favouritesUser' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }

        return $next($content);
    }
}
