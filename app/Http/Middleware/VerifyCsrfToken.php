<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends BaseVerifier
{

    protected function excludedRoutes($request)
    {
        $routes = [
            'mv16api/newsletter',
            'mv16api/subscription'
        ];

        foreach ($routes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }
        return false;
    }

    public function handle($request, Closure $next)
    {
        if ($this->isReading($request) || $this->excludedRoutes($request) || $this->tokensMatch($request)) {
            return $this->addCookieToResponse($request, $next($request));
        }

        throw new TokenMismatchException;
    }

}
