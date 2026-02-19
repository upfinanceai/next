<?php


namespace App\Modules\Card\Actions;

use App\Modules\Card\Adapters\SavoAdapter;
use App\Modules\Card\Adapters\WasabiAdapter;
use App\Modules\Card\Enum\CardProvider;
use Exception;
use Lorisleiva\Actions\Concerns\AsAction;

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
