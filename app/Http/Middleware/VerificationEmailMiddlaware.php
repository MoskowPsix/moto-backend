<?php

namespace App\Http\Middleware;

use App\Http\Resources\Errors\NotAuthUserResource;
use App\Http\Resources\Errors\NotVerificationEmailResouece;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificationEmailMiddlaware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|NotVerificationEmailResouece|NotAuthUserResource
    {
        if (empty($request->user())) {
            return NotAuthUserResource::make([]);
        }
        if (!$request->user()->hasVerifiedEmail()) {
            return NotVerificationEmailResouece::make([]);
        }
        return $next($request);
    }
}
