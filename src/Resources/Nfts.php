<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-derivatives
 *
 * @property-read Listing $List
 * @property-read Contract $Contract
 * @property-read Markets $Markets
 * @property-read MarketChart $MarketChart
 * @property-read Tickers $Tickers
 *
 * @method Listing List()
 * @method Contract Contract(string $contractId)
 * @method Markets Markets()
 * @method MarketChart MarketChart()
 * @method Tickers Tickers()
 */
class Nfts extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'nfts';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Listing' => 'List',
        'Contract',

        // PRO API
        'Markets',
        'MarketChart',
        'Tickers',
    ];
}
