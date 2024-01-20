<?php

namespace App\Http\Middleware;

use App\Enums\HttpStatusCode;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return auth()->guard('api')->check()
        ? response()->json(data: ['message' => "Giriş Yapmış Olduğunuz İçin Bu Sayfaya Erişiminiz Yok !!!"], status: Response::HTTP_FORBIDDEN)
        : $next($request);
    }
}
