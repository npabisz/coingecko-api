<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-exchanges
 *
 * @property-read Listing $List
 * @property-read Tickers $Tickers
 * @property-read VolumeChart $VolumeChart
 *
 * @method Listing List()
 * @method Tickers Tickers()
 * @method VolumeChart VolumeChart()
 */
class Exchanges extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'exchanges';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Listing' => 'List',
        'Tickers',
        'VolumeChart',
    ];
}
