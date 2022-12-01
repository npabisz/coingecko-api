<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-derivatives
 *
 * @property-read Exchanges $Exchanges
 *
 * @method Exchanges Exchanges(string $exchangeId = null)
 */
class Derivatives extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'derivatives';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Exchanges',
    ];
}
