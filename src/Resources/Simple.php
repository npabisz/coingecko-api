<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-simple
 *
 * @property-read Price $Price
 * @property-read TokenPrice $TokenPrice
 * @property-read SupportedVsCurrencies $SupportedVsCurrencies
 *
 * @method Price Price()
 * @method TokenPrice TokenPrice(string $platformId)
 * @method SupportedVsCurrencies SupportedVsCurrencies()
 */
class Simple extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'simple';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Price',
        'TokenPrice',
        'SupportedVsCurrencies',
    ];
}
