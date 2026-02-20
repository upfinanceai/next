<?php


namespace Modules\Card\Actions;

use Exception;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Adapters\SavoAdapter;
use Modules\Card\Adapters\WasabiAdapter;
use Modules\Card\Enum\CardProvider;

class GetCardProvider
{
    use AsAction;

    public function handle($card)
    {
        return match ($card->provider) {
            CardProvider::wasabi()->value => new WasabiAdapter(),
            CardProvider::savo()->value => new SavoAdapter(),
            default => throw new Exception('Invalid card provider'),
        };
    }
}
