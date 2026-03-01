<?php

namespace Modules\Web\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class WebAppAuthMiddleware extends Middleware
{
    protected function redirectTo($request)
    {
        return route('web.login');
    }
}
