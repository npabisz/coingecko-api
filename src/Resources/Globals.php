<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-global
 *
 * @property-read DecentralizedFinanceDefi $DecentralizedFinanceDefi
 * @property-read MarketCapChart $MarketCapChart
 *
 * @method DecentralizedFinanceDefi DecentralizedFinanceDefi()
 * @method MarketCapChart MarketCapChart()
 */
class Globals extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'global';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'DecentralizedFinanceDefi',
        'MarketCapChart',
    ];
}
