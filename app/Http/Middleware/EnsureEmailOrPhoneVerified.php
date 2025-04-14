<?php

namespace App\Http\Middleware;

use App\Http\Resources\Errors\NotAuthUserResource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailOrPhoneVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|NotAuthUserResource
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Пользователь не авторизован'], 401);
        }

        $user = Auth::user();

        // Проверяем, подтверждён ли email
        $isEmailVerified = $user->hasVerifiedEmail();

        // Проверяем, подтверждён ли телефон
        $isPhoneVerified = false;
        if ($user->phone()->exists()) {
            $phone = $user->phone()->first();
            $isPhoneVerified = !empty($phone->number_verified_at);
        }

        // Если ни email, ни телефон не подтверждены, возвращаем ошибку
        if (!$isEmailVerified && !$isPhoneVerified) {
            return response()->json(['message' => 'Необходимо подтвердить email или телефон'], 403);
        }

        // Продолжаем выполнение запроса
        return $next($request);
    }
}
