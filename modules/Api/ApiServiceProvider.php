<?php

namespace Modules\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/api.php', 'api');
    }

    public function boot()
    {
        JsonResource::withoutWrapping();
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
    }
}
