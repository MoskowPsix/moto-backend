<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;
class RaceAppointmentExists implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('userIdExists') && request()->has('appointmentUser')){
            $userId = request()->get('userIdExists');
//            dd($content->first()->appointments()->get());
            $content->withExists(['appointments' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }

        return $next($content);
    }
}
