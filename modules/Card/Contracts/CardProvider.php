<?php

namespace Modules\Card\Contracts;

use Modules\Card\Models\Card;

interface CardProvider
{
    public function createCard($data): Card;

    public function freezeCard($card);

    public function deposit($card, $amount);

    public function withdraw($card, $amount);
}
