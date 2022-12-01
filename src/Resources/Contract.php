<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-coins
 *
 * @property-read MarketChart $MarketChart
 *
 * @method MarketChart MarketChart()
 */
class Contract extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'contract';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'MarketChart',
    ];
}
