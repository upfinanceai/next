<?php

namespace Modules\Admin\Http\Controllers;

class HomeController
{
    public function __invoke()
    {
        return admin()->content(view('admin::dashboard'))->render();
    }
}
