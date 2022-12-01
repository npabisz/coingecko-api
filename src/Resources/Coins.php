<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-coins
 *
 * @property-read Listing $List
 * @property-read Markets $Markets
 * @property-read Tickers $Tickers
 * @property-read History $History
 * @property-read MarketChart $MarketChart
 * @property-read Ohlc $Ohlc
 * @property-read Contract $Contract
 * @property-read Categories $Categories
 *
 * @method Listing List()
 * @method Markets Markets()
 * @method Tickers Tickers()
 * @method History History()
 * @method MarketChart MarketChart()
 * @method Ohlc Ohlc()
 * @method Contract Contract(string $contractId)
 * @method Categories Categories()
 */
class Coins extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'coins';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Listing' => 'List',
        'Markets',
        'Tickers',
        'History',
        'MarketChart',
        'Ohlc',
        'Contract',
        'Categories',
    ];
}
