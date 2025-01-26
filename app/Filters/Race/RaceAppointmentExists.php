<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;
class RaceAppointmentExists implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('userId') && request()->has('appointmentUser')){
            $userId = request()->get('userId');
//            dd($content->first()->appointments()->get());
            $content->withExists(['appointments' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }

        return $next($content);
    }
}
