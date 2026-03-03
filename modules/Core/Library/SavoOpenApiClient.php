<?php

namespace Modules\Core\Library;

class SavoOpenApiClient
{
    public function __construct(
        public ?string $base_url,
        public ?string $api_key,
        public ?string $app_public_key,
        public ?string $app_private_key,
    ) {
        $this->base_url        = $api_url ?? config('services.save_openapi.base_url');
        $this->api_key         = $api_key ?? config('services.save_openapi.api_key');
        $this->app_public_key  = $app_public_key ?? config('services.save_openapi.app_public_key');
        $this->app_private_key = $app_private_key ?? config('services.save_openapi.app_private_key');
    }

    public static function make(...$args)
    {
        return new static(...$args);
    }
}
