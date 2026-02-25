<?php

namespace Modules\Webhook;

use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/webhook.php', 'webhook');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/webhook.php');
    }
}
