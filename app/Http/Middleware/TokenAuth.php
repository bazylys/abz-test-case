<?php

namespace App\Http\Middleware;

use App\Exceptions\NoAccessTokenProvidedException;
use App\Services\AccessTokenService;
use Closure;
use Illuminate\Http\Request;

class TokenAuth
{
    public $tokenService;

    public function __construct(AccessTokenService $service)
    {
        $this->tokenService = $service;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,)
    {
        $token = $request->header('token');

        $this->tokenService->check($token);

        $response =  $next($request);

        $this->tokenService->revokeToken($token);

        return $response;
    }
}
