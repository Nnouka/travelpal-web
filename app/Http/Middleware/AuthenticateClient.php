<?php

namespace App\Http\Middleware;

use App\CustomObjects\HttpStatus;
use App\Exceptions\ApiException;
use App\Services\AuthService;
use Closure;

class AuthenticateClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return AuthService::check($request) ? $next($request) : ApiException::report(
            "Invalid credentials", HttpStatus::HTTP_BAD_REQUEST, $request->getRequestUri()
        );
    }
}
