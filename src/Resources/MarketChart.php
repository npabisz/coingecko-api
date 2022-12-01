<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-coins
 *
 * @property-read Range $Range
 *
 * @method Range Range()
 */
class MarketChart extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'market_chart';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Range',
    ];
}
