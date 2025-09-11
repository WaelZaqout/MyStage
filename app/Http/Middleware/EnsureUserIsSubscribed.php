<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserIsSubscribed
{
    public function handle($request, Closure $next, string $audience)
    {
        $user = $request->user();

        if (! $user || ! $user->hasActivePlan($audience)) {
            return redirect()
                ->route('plans.index', ['aud' => $audience])
                ->with('error', 'هذا القسم يتطلب اشتراكاً نشطاً.');
        }

        return $next($request);
    }
}
