<?php

namespace Modules\Card\Services;

use Illuminate\Support\Facades\Log;

class CardService
{
    public function create()
    {
        Log::debug('card created');
    }
}
