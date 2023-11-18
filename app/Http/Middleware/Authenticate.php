<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if($request->route()->named('admin.dashboard'))
        {
            return $request->expectsJson() ? null : route('authorise.login');
        }
        return $request->expectsJson() ? null : route('customer.login');
    }
}
