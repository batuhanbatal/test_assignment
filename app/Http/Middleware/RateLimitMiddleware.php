<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
use App\Traits\Responseable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;

class RateLimitMiddleware extends ThrottleRequests
{
    use Responseable;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected function handleRequest($request, Closure $next, array $limits)
    {
        $user = Auth::user();

        if (!$user->subscription) {
            return Responseable::error('Please get a free or premium package from the subscription section.', null, 402);
        }

        $response = $next($request);
        $userKey = 'chat' .  $user->id;
        $userProductMaxAttempts =  $user->subscription->product->rate_limit;

        if ($this->limiter->tooManyAttempts($userKey, $userProductMaxAttempts)) {
            throw $this->buildException($request, $userKey, $userProductMaxAttempts);
        }
        $this->limiter->hit($userKey, null);

        $this->addHeaders(
            $response,
            $userProductMaxAttempts,
            $this->calculateRemainingAttempts($userKey, $userProductMaxAttempts)
        );

        return $response;
    }
}
