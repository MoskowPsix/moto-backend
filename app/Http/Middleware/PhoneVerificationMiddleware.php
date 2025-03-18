<?php

namespace App\Http\Middleware;

use App\Http\Resources\Errors\NotAuthUserResource;
use App\Http\Resources\Errors\NotVerificationEmailResouece;
use App\Http\Resources\Errors\NotVerificationPhoneResouece;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PhoneVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|NotAuthUserResource|NotVerificationPhoneResouece
    {
        if (empty(auth()->user())) {
            return NotAuthUserResource::make([]);
        }
        if (!auth()->user()->phone()->exists()) {
            return NotVerificationPhoneResouece::make([]);
        }
        if (!auth()->user()->phone()->first()->number_verified_at) {
            return NotVerificationPhoneResouece::make([]);
        }
        return $next($request);
    }
}
