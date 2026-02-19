<?php

namespace App\Modules\Asset\Events;

use App\Models\ExchangeOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExchangeOrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public ExchangeOrder $order
    ) {
        //
    }
}
