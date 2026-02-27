<?php

namespace Modules\WebApp\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class WebAppAuthMiddleware extends Middleware
{
    protected function redirectTo($request)
    {
        return route('webapp.login');
    }
}
