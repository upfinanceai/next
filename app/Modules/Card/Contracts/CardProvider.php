<?php

namespace App\Modules\Card\Contracts;

use App\Models\Card;

interface CardProvider
{
    public function createCard($data): Card;

    public function freezeCard($card);
}
