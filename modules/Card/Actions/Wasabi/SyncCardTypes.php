<?php


namespace Modules\Card\Actions\Wasabi;

use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Models\CardDesign;
use Modules\Core\Services\WasabiCardApiClient;

class SyncCardTypes
{
    use AsAction;

    public function handle()
    {
        $cardTypes = WasabiCardApiClient::make()->getCardTypes();
        foreach ($cardTypes as $cardType) {
            CardDesign::updateOrCreate([
                'provider'    => 'wasabi',
                'external_id' => $cardType['cardTypeId'],
            ], [
                'publisher' => Str::lower($cardType['organization']),
                'type'      => $cardType['type'] == 'Physical' ? 'physical' : 'digital',
                'meta'      => $cardType,
                'status'    => $cardType['status'] == 'online' ? 'active' : 'inactive',
                'currency'  => $cardType['cardPriceCurrency'],
                'model'     => $cardType['metadata']['cardHolderModel'] ?? '',
            ]);
        }
    }
}
