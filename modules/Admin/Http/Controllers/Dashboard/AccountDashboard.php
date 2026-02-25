<?php

namespace Modules\Admin\Http\Controllers\Dashboard;

class AccountDashboard
{
    public function __invoke()
    {
        return admin()->content(view('admin::dashboard'))->render();
    }
}
